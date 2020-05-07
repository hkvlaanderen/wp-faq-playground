;( function( $, window, undefined ) {

    'use strict'


    const fnmap = {
        'toggle': 'toggle',
        'show': 'add',
        'hide': 'remove'
    };
    const collapse = (selector, cmd) => {
        const targets = Array.from(document.querySelectorAll(selector));
        targets.forEach(target => {
            target.classList[fnmap[cmd]]('show');
        });
    };

    // Grab all the trigger elements on the page
    const triggers = Array.from(document.querySelectorAll('[data-toggle="collapse"]'));
    // Listen for click events, but only on our triggers
    window.addEventListener('click', (ev) => {

        const elm = ev.target;

        if (triggers.includes(elm)) {



            const selector = elm.getAttribute('data-target');
            if(elm.classList.contains('active')){
                elm.classList.remove('active');
            } else {
                [].forEach.call(triggers, function(el) {
                    // check if its active and if we are clicking on another one
                    if(el.classList.contains('active') && selector !== el.getAttribute('data-target')){
                        el.classList.remove("active");
                        const Sselector = el.getAttribute('data-target');
                        collapse(Sselector, 'toggle');
                    }



                });
                elm.classList.add('active');
            }

            collapse(selector, 'toggle');
        }
    }, false);

} ( jQuery, window ) );
