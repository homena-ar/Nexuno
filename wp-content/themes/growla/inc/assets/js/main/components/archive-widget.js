export const wrap_archive_year = () => {
    let els = document.querySelectorAll('.widget_archive a');
    if ( els.length < 1 ) return;

    els.forEach(el => {
        let [ month, year ] =  el.innerHTML.split(' ');
        el.innerHTML = '<span>' + month + '</span>' + '<sup>' + year + '</sup>';
    });
}