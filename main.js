function toggle(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }

function togglePassword() {

    const fields = document.querySelectorAll('.password');

    fields.forEach(field => {
        if(field.type === 'password'){
            field.type = 'text';
        }else{
            field.type = 'password';
        }
    });

}


function checkRadio(id){   
    document.getElementById(id).checked = true;
}


function keepScrollOnNextLoad() {
    localStorage.setItem('keepScroll', '1');
    localStorage.setItem('scrollPos', window.scrollY);
}

function resetScrollOnNextLoad() {
    localStorage.removeItem('keepScroll');
    localStorage.removeItem('scrollPos');
}
 
document.addEventListener("DOMContentLoaded", function() {
    if (localStorage.getItem('keepScroll') === '1') {
        var scrollPos = localStorage.getItem('scrollPos');

        if (scrollPos) {
            window.scrollTo(0, parseInt(scrollPos));
        }

        localStorage.removeItem('keepScroll');
        localStorage.removeItem('scrollPos');
    }
});
 
const checkboxes = document.querySelectorAll('input[type="checkbox"]');

const detectToggleOnce = (e) => {
  e.target.classList.add('toggled-once');
};

checkboxes.forEach(checkbox => {
  checkbox.addEventListener('click', detectToggleOnce, { once: true });
});

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('input[type="password"]').forEach(function (input) {
        var parent = input.parentNode;
        var label = input.previousElementSibling;

        var wrap = document.createElement('span');
        wrap.style.cssText = 'position:relative;display:block;flex:1 1 auto;width:100%;';

        parent.insertBefore(wrap, input);
        wrap.appendChild(input);

        input.style.setProperty('padding-right', '46px', 'important');

        if (label && label.tagName === 'LABEL') {
            parent.style.cssText += ';display:flex;align-items:center;gap:16px;';
            label.style.flex = '0 0 150px';
        }

        var eye = document.createElement('span');
        eye.textContent = '👁';
        eye.title = 'Wachtwoord tonen/verbergen';
        eye.style.cssText = 'position:absolute;right:16px;top:50%;transform:translateY(-50%);cursor:pointer;user-select:none;font-size:18px;opacity:.5;';

        wrap.appendChild(eye);

        eye.addEventListener('click', function () {
            var hidden = input.type === 'password';
            input.type = hidden ? 'text' : 'password';
            eye.style.opacity = hidden ? '1' : '.5';
        });
    });

});