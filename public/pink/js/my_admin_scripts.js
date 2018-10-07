jQuery(document).ready(function ($) {

    // Диалоговое окно удаления
    $(".btn-french-5").on('click', function (e) {
        $("#dialog-confirm").dialog({
            autoOpen: false,
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
                "Удалить": function () {
                    $(this).dialog("close");
                    $(e.target).trigger("click.confirmed");
                },
                "Отмена": function () {
                    $(this).dialog("close");
                }
            },
            close: function () {
                $(e.target).trigger('blur');
            }
        });
        e.preventDefault();
        $("#dialog-confirm").dialog("open");
    });


    // Закрепить статью
    $('input[name=fixed]').on('change', function (e) {
        let $label = $(this).closest('label');
        let data = 'fixed=';
        if ($(this).is(":checked")) {
            $label.find('span').text('Открепить');
            $label.addClass('btn-come-to-me-4')
                .removeClass('btn-clear-3')
                .attr('title', 'Убрать статью с главной страницы');
            data += true;
        } else {
            $label.find('span').text('Закрепить');
            $label.addClass('btn-clear-3')
                .removeClass('btn-come-to-me-4')
                .attr('title', 'Предложить статью на главной странице');
            data += false;
        }
        $.ajax({
            url: $(this).attr('data-action'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: data,
            datatype: 'text',
            success: function (result) {
                // console.log(result);
            },
            error: function () {
                // console.log('error');
            }
        });
    });


    // monthPicker
    $.datepicker.regional['ru'] = {
        closeText: 'Закрыть',
        prevText: 'Пред',
        nextText: 'След',
        currentText: 'Сегодня',
        monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
        monthNamesShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
        dayNames: ['воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'],
        dayNamesShort: ['вск', 'пнд', 'втр', 'срд', 'чтв', 'птн', 'сбт'],
        dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
        weekHeader: 'Нед',
        dateFormat: 'dd.mm.yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['ru']);

    $('.monthPicker').datepicker({
        dateFormat: 'MM yy',
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        maxDate: 0,
        onClose: function (dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).val($.datepicker.formatDate('MM yy', new Date(year, month, 1)));
        }
    });

    $('.monthPicker').focus(function () {
        $(".ui-datepicker-calendar").hide();
        $("#ui-datepicker-div").position({
            my: "left top",
            at: "left bottom",
            of: $(this)
        });
    });
});