$(document).ready(function () {
    $("#contact_phone").mask("8 999 999 99 99");

    function displayError(error_text) {
        $("#error_text").text(error_text);
        $("#error_text").addClass("active");
        setTimeout(() => $("#error_text").removeClass("active"), 5000);
    }

    $(document).on("submit", "#contact_data", function (e) {
        e.preventDefault();

        const form_data = new FormData(e.target);

        // безопасную обработку строки не делаю,
        // т.к. эти функции выполняются в PDO,
        // которое использую для соединнения с БД
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
                    $("ul").prepend(
                        "<li><h3>" +
                            contact_name +
                            "</h3><i class='icon-cancel' data-id=" +
                            data["result_data"] +
                            "></i><p>" +
                            contact_phone +
                            "</p></li>"
                    );
                    $("input[type='text']").val("");
                } else if (data["error_code"] == 23000) displayError("Такой телефон уже есть");
                else
                    displayError(
                        "Извините, произошла какая-то ошибка. Мы уже работаем над ее устранением"
                    );
            }
        );
    });

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
                else displayError("Не получилось удалить. Администратор разбирается с проблемой");
            }
        );
    });
});
