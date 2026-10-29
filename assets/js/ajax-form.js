$(document).ready(function () {

    $("#contactForm").on("submit", async function (e) {
        e.preventDefault();

        const form = this;
        const submitBtn = $(form).find("button[type='submit']");

        submitBtn.prop("disabled", true);

        const formData = new FormData(form);

        // Web3Forms Access Key
        formData.append("access_key", "73b36be4-1792-438c-9cbf-e73d2f48ff21");

        // Email Subject
        formData.append("subject", "New Contact Form Submission");

        // Sender Name
        formData.append("from_name", "Global Amigo");

        // Optional
        formData.append("replyto", $("#email").val());

        try {

            const response = await fetch("https://api.web3forms.com/submit", {
                method: "POST",
                body: formData
            });

            const result = await response.json();

            if (result.success) {

                $(".ajax-response")
                    .removeClass("error")
                    .addClass("success")
                    .html("Your message has been sent successfully.");

                form.reset();

            } else {

                $(".ajax-response")
                    .removeClass("success")
                    .addClass("error")
                    .html(result.message);

            }

        } catch (error) {

            $(".ajax-response")
                .removeClass("success")
                .addClass("error")
                .html("Something went wrong. Please try again.");

            console.error(error);

        } finally {

            submitBtn.prop("disabled", false);

        }

    });

});