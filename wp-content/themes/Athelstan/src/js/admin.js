jQuery(document).ready(function($) {
    const urlParams = new URLSearchParams(window.location.search);
    const key_acf = urlParams.get('key');
    if (key_acf && key_acf != null) {
        $('.acf-tab-group li').removeClass('active');
        $('a[data-key="' + key_acf + '"]').trigger('click')
    }
});