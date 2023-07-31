$(document).ready(function () {
    $("#contact_phone").mask("8 999 999 99 99");

    // сообщения о различных ошиибках
    function displayError(error_text) {
        $("#error_text").text(error_text);
        $("#error_text").addClass("active");
        setTimeout(() => $("#error_text").removeClass("active"), 5000);
    }

    switch (result_code) {
        case 1:
            displayError("БД недоступна. Сообщите администратору");
            break;
        case 2:
            displayError("Еще не добавлено ни одного контакта");
            break;
        case 3:
            displayError("Список контактов недоступен. Сообщите администратору");
    }

    // подсвечивание неверно заполненных полей
    $(document).on("change", "input[type='text']", function () {
        if (!this.checkValidity()) $(this).addClass("invalid");
        else $(this).removeClass("invalid");
    });

    // добавление контакта
    $(document).on("submit", "#contact_data", function (e) {
        e.preventDefault();
        const form_data = new FormData(e.target);

        // безопасная обработка строк не требуется
        // т.к. набор символов для ввода в поля строго ограничен
        const contact_name = form_data.get("contact_name");
        const contact_phone = form_data.get("contact_phone");
        const phone_parts = contact_phone.split(" ");

        $.post(
            "add_contact.php",
            {
                contact_name: contact_name,
                contact_code: phone_parts[1],
                contact_phone: phone_parts[2] + phone_parts[3] + phone_parts[4],
            },
            function (data) {
                data = JSON.parse(data);
                if (data["result"]) {
                    // можно было сделать шаблон для этого кусочка и вызывать его
                    // т.к. он используется в двух местах
                    // с другой стороны, это лишнее обращение к серверу
                    // клонирование не подойдет, т.к. список может быть пустым
                    $("ul").prepend(
                        "<li><div class='name_delete'><h3>" +
                            contact_name +
                            "</h3><i class='icon-cancel' data-id=" +
                            data["result_data"] +
                            "></i></div><p>" +
                            contact_phone +
                            "</p></li>"
                    );
                    $("input[type='text']").val("");
                } else if (data["error_code"] == 23000) displayError("Такой телефон уже есть");
                else displayError("Неизвестная ошибка. Сообщите администратору");
            }
        );
    });

    // удаление контакта
    $(document).on("click", ".icon-cancel", function () {
        if (!confirm("Удалить контакт?")) return false;
        const contact_item = $(this).closest("li");
        $.post(
            "delete_contact.php",
            {
                contact_id: $(this).attr("data-id"),
            },
            function (data) {
                data = JSON.parse(data);
                if (data["result"]) contact_item.remove();
                else displayError("Ошибка при удалении. Сообщите администратору");
            }
        );
    });
});
