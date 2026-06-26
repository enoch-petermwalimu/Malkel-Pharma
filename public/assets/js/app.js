/* =====================================================
   MALKEL PHARMA ERP
   APP.JS
===================================================== */

/* =====================================================
   DOM READY
===================================================== */

document.addEventListener(
'DOMContentLoaded',
function(){

    initializeSidebar();

    initializeOverlay();

    initializeFloatingElements();

    initializeCounters();

    initializeRevealAnimations();

    initializeActiveNavigation();

});

/* =====================================================
   SIDEBAR MANAGEMENT
===================================================== */

function initializeSidebar(){

    const sidebar =
    document.getElementById(
        'sidebar'
    );

    const toggle =
    document.getElementById(
        'menuToggle'
    );

    const overlay =
    document.getElementById(
        'sidebarOverlay'
    );

    if(!sidebar || !toggle){
        return;
    }

    toggle.addEventListener(
    'click',
    function(){

        if(window.innerWidth <= 992){

            sidebar.classList.toggle(
                'active'
            );

            if(overlay){

                overlay.classList.toggle(
                    'active'
                );
            }

        }else{

            sidebar.classList.toggle(
                'collapsed'
            );

            const main =
            document.getElementById(
                'main'
            );

            if(main){

                main.classList.toggle(
                    'expanded'
                );
            }
        }
    });
}

/* =====================================================
   OVERLAY
===================================================== */

function initializeOverlay(){

    const overlay =
    document.getElementById(
        'sidebarOverlay'
    );

    const sidebar =
    document.getElementById(
        'sidebar'
    );

    if(!overlay || !sidebar){
        return;
    }

    overlay.addEventListener(
    'click',
    function(){

        sidebar.classList.remove(
            'active'
        );

        overlay.classList.remove(
            'active'
        );
    });
}

/* =====================================================
   ACTIVE NAVIGATION
===================================================== */

function initializeActiveNavigation(){

    const currentPath =
    window.location.pathname;

    const links =
    document.querySelectorAll(
        '.nav a'
    );

    links.forEach(link=>{

        const href =
        link.getAttribute('href');

        if(
            href &&
            currentPath.startsWith(href) &&
            href !== '/'
        ){
            link.classList.add(
                'active'
            );
        }
    });
}

/* =====================================================
   FLOATING PHARMA EFFECTS
===================================================== */

function initializeFloatingElements(){

    const pills =
    document.querySelectorAll(
        '.floating-pill'
    );

    if(!pills.length){
        return;
    }

    document.addEventListener(
    'mousemove',
    function(e){

        pills.forEach(
        function(pill,index){

            const speed =
            (index + 1) * 0.004;

            const x =
            e.clientX * speed;

            const y =
            e.clientY * speed;

            pill.style.transform =
            `translate(${x}px,${y}px)`;
        });
    });
}

/* =====================================================
   COUNTER ANIMATION
===================================================== */

function initializeCounters(){

    const counters =
    document.querySelectorAll(
        '[data-counter]'
    );

    counters.forEach(counter=>{

        const target =
        parseFloat(
            counter.dataset.counter
        );

        if(isNaN(target)){
            return;
        }

        animateCounter(
            counter,
            target
        );
    });
}

function animateCounter(
element,
target
){

    let current = 0;

    const increment =
    target / 60;

    const interval =
    setInterval(
    function(){

        current += increment;

        if(current >= target){

            current = target;

            clearInterval(
                interval
            );
        }

        element.innerText =
        formatCounterValue(
            current
        );

    },20);
}

function formatCounterValue(
value
){

    return Number(
        value
    ).toLocaleString();
}

/* =====================================================
   REVEAL ANIMATION
===================================================== */

function initializeRevealAnimations(){

    const elements =
    document.querySelectorAll(

        '.card,' +
        '.panel-card,' +
        '.metric-card,' +
        '.hero-v2'
    );

    if(!elements.length){
        return;
    }

    const observer =
    new IntersectionObserver(

    entries=>{

        entries.forEach(
        entry=>{

            if(
                entry.isIntersecting
            ){

                entry.target.classList.add(
                    'fade-in'
                );
            }
        });

    },{
        threshold:0.15
    });

    elements.forEach(
    element=>{

        observer.observe(
            element
        );
    });
}

/* =====================================================
   TABLE SEARCH
===================================================== */

function tableSearch(
inputId,
tableId
){

    const input =
    document.getElementById(
        inputId
    );

    const table =
    document.getElementById(
        tableId
    );

    if(!input || !table){
        return;
    }

    input.addEventListener(
    'keyup',
    function(){

        const value =
        this.value
        .toLowerCase();

        const rows =
        table.querySelectorAll(
            'tbody tr'
        );

        rows.forEach(row=>{

            const text =
            row.innerText
            .toLowerCase();

            row.style.display =
            text.includes(value)
            ? ''
            : 'none';
        });
    });
}

/* =====================================================
   CONFIRM DELETE
===================================================== */

function confirmDelete(
message =
'Are you sure ?'
){

    return confirm(
        message
    );
}

/* =====================================================
   TOAST NOTIFICATIONS
===================================================== */

function showToast(
message,
type='success'
){

    const toast =
    document.createElement(
        'div'
    );

    toast.className =
    `malkel-toast ${type}`;

    toast.innerHTML =
    message;

    document.body.appendChild(
        toast
    );

    setTimeout(
    function(){

        toast.classList.add(
            'show'
        );

    },50);

    setTimeout(
    function(){

        toast.remove();

    },3500);
}

/* =====================================================
   WINDOW RESIZE
===================================================== */

window.addEventListener(
'resize',
function(){

    const sidebar =
    document.getElementById(
        'sidebar'
    );

    const overlay =
    document.getElementById(
        'sidebarOverlay'
    );

    if(
        window.innerWidth > 992
    ){

        if(sidebar){

            sidebar.classList.remove(
                'active'
            );
        }

        if(overlay){

            overlay.classList.remove(
                'active'
            );
        }
    }
});

/* =====================================================
   GLOBAL HELPERS
===================================================== */

window.confirmDelete =
confirmDelete;

window.showToast =
showToast;

window.tableSearch =
tableSearch;