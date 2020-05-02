const login = () => {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    const instance = axios.create({
        baseURL: settings.url,
        timeout: 1000
    });

    instance.post('getToken', {
        "username": document.getElementById("input_username").value,
        "password": document.getElementById("input_password").value
    })
        .then(response => {
            const respmesssage = response.data;
            console.log(respmesssage);
            var obj = JSON.parse(JSON.stringify(respmesssage));

            if (obj.hasOwnProperty('http_code')) {
                toastr["error"]("Wrong username or password");
            } else if (obj.hasOwnProperty('token')) {
                localStorage.setItem("user_token", obj["token"]);
                toastr["success"]("Logged in!");
                window.location.replace("dashboard.html");
            } else {
                toastr["error"]("Something went wrong... sorry :(");
            }
        })
        .catch(error => {
            console.error(error);
            toastr["error"]("Something went wrong... sorry :(");
        });
};