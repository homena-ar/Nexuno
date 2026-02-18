export class Select {
    // this is the select element
    #element;
    // this is the custom element generated
    #custom_element;
    // source element is used to fetch data from another element
    #source_element = null;
    // the selector inside the source element that contains the data
    // it can be list item if the source element is a ul.
    #source_selector = null;

    constructor( element ) {
        this.#element = element;

        // set source element if it is provided
        let source_id = element.dataset.sourceTarget;
        if ( source_id !== '' ) {
            this.#source_element = document.querySelector(source_id);
        }

        // set source selector if it is provided
        let source_selector = element.dataset.sourceSelector;
        if ( source_selector !== '' ) {
            this.#source_selector = source_selector;
        }

        // primary handler
        this.#main();
    }

    #main() {
        // hide the original element
        this.#hideOriginal();

        // create custom element
        this.#custom_element = this.#createCustomSelect();

        // add to dom
        this.#appendAsSibling(this.#element, this.#custom_element);
        this.#custom_element.appendChild(this.#element);

        this.#selectionHandler();
    }

    #toggleMenu() {
        let classes = this.#custom_element.querySelector('.selectify').classList;
        if ( classes.contains('shown') )
            classes.remove('shown');
        else 
            classes.add('shown');
    }   

    #selectionHandler() {
        document.addEventListener('click', (e) => {
            let target = e.target;
            
            if ( target.closest('.selectify-wrapper') !== this.#custom_element ) return;

            if ( target.matches('.selectify .active') ) {
                this.#toggleMenu();
                return;
            }

            if ( !target.matches('.selectify li') ) return;
            
            let element = target.closest('.selectify');
            let active = element.querySelector('.active');


            element.querySelector('.selected').classList.remove('selected');
            target.classList.add('selected');

            this.customOption(target, active, true);
            // change active value in select
            this.#element.value = active.dataset.value;
            
            // trigger change event
            let event = new CustomEvent('change');
            this.#element.dispatchEvent(event);
            
            this.#toggleMenu();
        })
    }

    #hideOriginal() {
        this.#element.style.setProperty('opacity', 0);
        this.#element.style.setProperty('visibility', 'hidden');
    }

    #appendAsSibling(sibling, element) {
        let parent = sibling.parentNode;
        parent.appendChild(element);
    }

    #createCustomSelect() {
        let wrapper =  document.createElement('div');
        wrapper.className = 'selectify-wrapper';

        let main = document.createElement('div');
        main.className = 'selectify';

        let active_wrapper = document.createElement('div');
        active_wrapper.className = 'active-wrapper';

        active_wrapper.innerHTML += '<div class="arrow-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M362.7 203.9l-159.1 144c-6.125 5.469-15.31 5.469-21.44 0L21.29 203.9C14.73 197.1 14.2 187.9 20.1 181.3C26.38 174.4 36.5 174.5 42.73 180.1L192 314.5l149.3-134.4c6.594-5.877 16.69-5.361 22.62 1.188C369.8 187.9 369.3 197.1 362.7 203.9z"/></svg></div>';

        let active = document.createElement('div');
        active.className = 'active';

        // return if there are no options
        if ( this.#element.options.length < 1 ) {
            wrapper.appendChild(main);
            return wrapper;    
        }

        let options = document.createElement('ul');

        // use data from options
        if ( this.#source_element === null || this.#source_selector === null ) {

            Array.from(this.#element.options).forEach(option => {
                
                let custom_option = document.createElement('li');
                
                if ( option.selected ) {
                    active.innerHTML = option.innerHTML;
                    // active = this.customOption(option, active);

                    active.innerHTML = option.innerHTML;
                    active.dataset.value = option.value;

                    custom_option.className = 'selected';
                }
                
                custom_option.innerHTML = option.innerHTML;
                custom_option.dataset.value = option.value;

                // custom_option = this.customOption(option, custom_option);
                options.appendChild(custom_option);
            });

        } 
        // use data from source element
        else if ( this.#source_selector !== null ) {

            let els = this.#source_element.querySelectorAll(this.#source_selector);
            

            Array.from(els).forEach(option => {
                let custom_option = document.createElement('li');

                if ( option.dataset.selected === 'selected' ) {
                    // active.innerHTML = option.innerHTML;
                    // active = this.customOption(option, active);

                    active.innerHTML = option.innerHTML;
                    active.dataset.value = option.value;
                    
                    custom_option.className = 'selected';
                }
                    

                custom_option.innerHTML = option.innerHTML;
                custom_option.dataset.value = option.dataset.value;

                // custom_option = this.customOption(option, custom_option);
                options.appendChild(custom_option);
            });
            
        }

        // options.scrollbar = OverlayScrollbars(options, {
        //     overflowBehavior : {
        //         x : 'hidden',
        //         y : 'scroll'
        //     },
        // });

        active_wrapper.appendChild(active);
        main.appendChild(active_wrapper);
        main.appendChild(options);

        wrapper.appendChild(main);

        return wrapper;

    }

    customOption(option, element, change_select_value = false) {
        element.innerHTML = option.innerHTML;
        element.dataset.value = option.dataset.value;
        
        if ( change_select_value ) {
            this.#element.value = element.dataset.value;
        }
        
        return element;
    }
}