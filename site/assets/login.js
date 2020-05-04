const checkLoginStatus = (url) => {
    if (localStorage.getItem("user_token") !== null) {
        window.location.replace(url+"site/dashboard");
    }
}

const login = (url) => {
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
                window.location.replace(url+"site/dashboard");
            } else {
                toastr["error"]("Something went wrong... sorry :(");
            }
        })
        .catch(error => {
            console.error(error);
            toastr["error"]("Something went wrong... sorry :(");
        });
};

var input = document.getElementById("input_password");

// Execute a function when the user releases a key on the keyboard
input.addEventListener("keyup", function(event) {
  // Number 13 is the "Enter" key on the keyboard
  if (event.keyCode === 13) {
    // Cancel the default action, if needed
    event.preventDefault();
    // Trigger the button element with a click
    document.getElementById("loginbtn").click();
  }
});

var input2 = document.getElementById("input_username");

// Execute a function when the user releases a key on the keyboard
input2.addEventListener("keyup", function(event) {
  // Number 13 is the "Enter" key on the keyboard
  if (event.keyCode === 13) {
    // Cancel the default action, if needed
    event.preventDefault();
    // Trigger the button element with a click
    document.getElementById("loginbtn").click();
  }
});