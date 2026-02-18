export const wrap_tables = () => {
    let tables = document.querySelectorAll('table');
    if ( tables.length < 1 ) return;
    tables.forEach(table => {
        let caption = table.querySelector('caption');
        
        let main_wrapper = document.createElement('div');
        main_wrapper.className = 'table-outer-wrapper';

        let div = document.createElement('div');
        div.className = 'table-wrapper';
        table.parentNode.insertBefore(main_wrapper, table);
        
        if (  caption != null )
            main_wrapper.appendChild(caption);
            
        div.appendChild(table);
        main_wrapper.appendChild(div);
   
    })
}