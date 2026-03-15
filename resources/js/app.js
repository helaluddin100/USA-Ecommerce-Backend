import './bootstrap';
import $ from 'jquery';
import 'select2/dist/css/select2.min.css';
import 'select2';

window.$ = window.jQuery = $;

function initSelect2() {
    if (typeof $.fn.select2 !== 'function') return;

    $('.js-select2').each(function () {
        const $el = $(this);
        if ($el.data('select2')) return;

        $el.select2({
            width: '100%',
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initSelect2();
});

