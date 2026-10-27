<?php
	include 'core.inc.php';
    include 'polls.inc.php';
	//only use if not on index.php
	if(!logged_in()){redirect('index.php');}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="UTF-8"/>
	<meta name="description" content="Yearbook [Schoolname]"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="favicon.png" type="image/png"/>
	<title>Year Book - Polls</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="main.css">
	<script src="main.js"></script>
</head>
<body>
	<div class="page">
		<?php 
            include 'header.inc.php'; 
            show_polls($con);
        ?>
<!--
        <div class="card locked-card" id="locked-view" style="display:none;">
            <div class="lock-icon">🔒</div>
            <h2>Polls đang khoá</h2>
            <p>Trang polls sẽ mở lại khi cả lớp đã hoàn tất đăng ký. Quay lại sau nhé!</p>
        </div>
        <div class="card poll-panel" id="vote-view" style="display:none;">
            <h2 class="page-heading">Who's most likely to?</h2>
            <form id="poll-form"></form>
            <div class="submit-wrap">
                <button type="submit" form="poll-form" class="submit-btn">Submit</button>
            </div>
            <p class="form-note">Mỗi người chỉ được vote 1 lần. Sau khi submit, bạn sẽ thấy kết quả tổng hợp của cả lớp.</p>
        </div>
        <div class="card poll-panel" id="result-view" style="display:none;">
            <h2 class="page-heading">Who's most likely to?</h2>
            <div id="result-list"></div>
        </div>
        <div class="dev-reset" id="dev-reset" style="display:none;">
            <a href="#" id="reset-link">(dùng để reset lại từ đầu - xoá hết toàn bộ vote)</a>
        </div>
    </div>
    <datalist id="members-list"></datalist>
    <script>
        const CLASS_MEMBERS = [
            "Full Name 1", "Full Name 2", "Full Name 3", "Full Name 4",
            "Full Name 5", "Full Name 6", "Full Name 7", "Full Name 8"
        ];
 
        
        const POLL_QUESTIONS = [
            { id: "millionaire", icon: "💰", text: "Most likely to become a millionaire?", type: "single" },
            { id: "popular",      icon: "🌟", text: "Most popular in class?",               type: "single" },
            { id: "famous",       icon: "🎤", text: "Most likely to become famous?",        type: "single" },
            { id: "couple",       icon: "💞", text: "Most likely to become a couple?",      type: "pair"   },
            { id: "clown",        icon: "😂", text: "The class clown (funniest)?",          type: "single" },
            { id: "abroad",       icon: "✈️", text: "Most likely to live abroad?",          type: "single" }
        ];
 
        const VOTES_KEY = "yearbook_poll_votes";
        const VOTED_FLAG_KEY = "yearbook_has_voted";
 
        
        const CLASS_FULLY_SIGNED_UP = true;
 
        
 
        function getVotes() {
            try { return JSON.parse(localStorage.getItem(VOTES_KEY)) || {}; }
            catch (e) { return {}; }
        }
        function saveVotes(votes) { localStorage.setItem(VOTES_KEY, JSON.stringify(votes)); }
        function addVote(votes, questionId, choiceKey) {
            if (!votes[questionId]) votes[questionId] = {};
            votes[questionId][choiceKey] = (votes[questionId][choiceKey] || 0) + 1;
        }
        function hasVoted() { return localStorage.getItem(VOTED_FLAG_KEY) === "true"; }
        function markVoted() { localStorage.setItem(VOTED_FLAG_KEY, "true"); }
        function resetPollDemo() {
            localStorage.removeItem(VOTES_KEY);
            localStorage.removeItem(VOTED_FLAG_KEY);
        }
 
        
 
        function buildVoteForm() {
            const form = document.getElementById('poll-form');
            const membersList = document.getElementById('members-list');
 
            CLASS_MEMBERS.forEach(name => {
                const opt = document.createElement('option');
                opt.value = name;
                membersList.appendChild(opt);
            });
 
            POLL_QUESTIONS.forEach(q => {
                const block = document.createElement('div');
                block.className = 'poll-q-block';
                block.dataset.qid = q.id;
 
                const qText = document.createElement('div');
                qText.className = 'poll-q-text';
                qText.innerHTML = `<span class="q-icon">${q.icon}</span>${q.text}`;
                block.appendChild(qText);
 
                const subIds = q.type === 'pair' ? [q.id + '-a', q.id + '-b'] : [q.id];
                subIds.forEach(subId => {
                    const row = document.createElement('div');
                    row.className = 'vote-row';
                    row.innerHTML = `
                        <span class="vote-label">Vote</span>
                        <input type="text" class="vote-input" list="members-list"
                               placeholder="Nhập tên..." data-qid="${subId}" autocomplete="off">
                    `;
                    block.appendChild(row);
                });
 
                const tag = document.createElement('div');
                tag.className = 'selected-tag';
                tag.dataset.tagFor = q.id;
                block.appendChild(tag);
 
                form.appendChild(block);
            });
 
            form.addEventListener('input', (e) => {
                if (!e.target.classList.contains('vote-input')) return;
                const qid = e.target.dataset.qid;
                const baseId = qid.replace(/-a$|-b$/, '');
                const q = POLL_QUESTIONS.find(item => item.id === baseId);
                const tag = form.querySelector(`.selected-tag[data-tag-for="${baseId}"]`);
 
                if (q.type === 'pair') {
                    const a = form.querySelector(`[data-qid="${baseId}-a"]`).value.trim();
                    const b = form.querySelector(`[data-qid="${baseId}-b"]`).value.trim();
                    tag.textContent = (a && b) ? `${a} và ${b} đã được chọn` : (a || b ? `${a || b} đã được chọn` : '');
                } else {
                    const v = e.target.value.trim();
                    tag.textContent = v ? `${v} đã được chọn` : '';
                }
            });
 
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                let allValid = true;
                const answers = {};
 
                POLL_QUESTIONS.forEach(q => {
                    const block = form.querySelector(`.poll-q-block[data-qid="${q.id}"]`);
                    block.classList.remove('invalid');
 
                    if (q.type === 'pair') {
                        const a = form.querySelector(`[data-qid="${q.id}-a"]`).value.trim();
                        const b = form.querySelector(`[data-qid="${q.id}-b"]`).value.trim();
                        if (!a || !b || a === b) {
                            block.classList.add('invalid');
                            allValid = false;
                        } else {
                            answers[q.id] = [a, b].sort().join('||');
                        }
                    } else {
                        const v = form.querySelector(`[data-qid="${q.id}"]`).value.trim();
                        if (!v) {
                            block.classList.add('invalid');
                            allValid = false;
                        } else {
                            answers[q.id] = v;
                        }
                    }
                });
 
                if (!allValid) {
                    alert('Bạn nhớ điền đủ tất cả các câu hỏi trước khi Submit nhé!');
                    return;
                }
 
                const votes = getVotes();
                Object.keys(answers).forEach(qid => addVote(votes, qid, answers[qid]));
                saveVotes(votes);
                markVoted();
 
                showView('result');
                buildResultList();
            });
        }
 
       
 
        function buildResultList() {
            const votes = getVotes();
            const resultList = document.getElementById('result-list');
            resultList.innerHTML = '';
            
            POLL_QUESTIONS.forEach(q => {
                const item = document.createElement('div');
                item.className = 'result-item';
 
                const qEl = document.createElement('div');
                qEl.className = 'result-q';
                qEl.innerHTML = `<span class="q-icon">${q.icon}</span>${q.text}`;
                item.appendChild(qEl);
 
                const choices = votes[q.id];
                if (!choices || Object.keys(choices).length === 0) {
                    const empty = document.createElement('div');
                    empty.className = 'empty-votes';
                    empty.textContent = 'Chưa có lượt vote nào cho câu này.';
                    item.appendChild(empty);
                } else {
                    let winnerKey = null, winnerCount = -1;
                    Object.entries(choices).forEach(([key, count]) => {
                        if (count > winnerCount) { winnerKey = key; winnerCount = count; }
                    });
 
                    const winnerRow = document.createElement('div');
                    winnerRow.className = 'result-winner';
    
                        if (q.type === 'pair') {
                            const [nameA, nameB] = winnerKey.split('||');
                            winnerRow.innerHTML = `
                                <span class="avatar-dot">${nameA.charAt(0)}</span>
                                <span class="name">${nameA}</span>
                                <span class="and">và</span>
                                <span class="avatar-dot pink">${nameB.charAt(0)}</span>
                                <span class="name">${nameB}</span>
                                <span class="vote-count">${winnerCount} phiếu</span>
                            `;
                        } else {
                            winnerRow.innerHTML = `
                                <span class="avatar-dot">${winnerKey.charAt(0)}</span>
                                <span class="name">${winnerKey}</span>
                                <span class="vote-count">${winnerCount} phiếu</span>
                            `;
                        }
                        item.appendChild(winnerRow);
                    }
    
                resultList.appendChild(item);
            });
        }
 
        
 
        function showView(view) {
            document.getElementById('locked-view').style.display = view === 'locked' ? 'block' : 'none';
            document.getElementById('vote-view').style.display = view === 'vote' ? 'block' : 'none';
            document.getElementById('result-view').style.display = view === 'result' ? 'block' : 'none';
            document.getElementById('dev-reset').style.display = view === 'result' ? 'block' : 'none';
        }
 
 
        buildVoteForm();
 
        if (!CLASS_FULLY_SIGNED_UP) {
            showView('locked');
        } else if (hasVoted()) {
            buildResultList();
            showView('result');
        } else {
            showView('vote');
        }
 
        document.getElementById('reset-link').addEventListener('click', (e) => {
            e.preventDefault();
            if (confirm('Xoá hết phiếu vote hiện tại để test lại từ đầu?')) {
                resetPollDemo();
                location.reload();
            }
        });
    </script>
-->
</body>
</html>