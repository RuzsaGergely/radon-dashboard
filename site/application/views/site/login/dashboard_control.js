const instance = axios.create({
    baseURL: 'http://beast.spinehouse.hu:8080/radon/api/',
    timeout: 1000
});

const checkLoginStatus = () => {
    if (localStorage.getItem("user_token") === null) {
        window.location.replace("index.html");
    } else {
        //<a class="dropdown-item" href="#">Action</a>
        let dropdownmenu = document.getElementById("serverList");

        instance.get('getServers')
            .then(response => {
                const respmesssage = response.data;
                console.log(respmesssage);
                var obja = JSON.parse(JSON.stringify(respmesssage));
                //dropdownmenu.innerHTML += "<a class=\"dropdown-item\" href=\"#\" onclick=\"displayServer(" + obj.server_number + ")\">"+obj.server_name+"</a>"
                obja.forEach(function(item){
                    dropdownmenu.innerHTML += "<a class=\"dropdown-item\" href=\"#\" onclick=\"displayServer(" + item.server_number + ")\">"+item.server_name+"</a>"
                  });
                
            })
            .catch(error => {
                console.error(error);
                toastr["error"]("Something went wrong... sorry :(");
            });
    }
}

const displayServer = (serverid) => {
    let container = document.getElementById("display-container");
    container.innerHTML = " <div class=\"row mt-3\"> <div class=\"col-sm\" id=\"serverNumber\"> Selected server is #"+serverid+"</div> </div> <div class=\"row mt-3\"> <div class=\"col-sm\"> <div class=\"card\"> <h5 class=\"card-header\">Change Teamnames</h5> <div class=\"card-body\"> <form> <div class=\"form-group\"> <input type=\"text\" class=\"form-control\" id=\"changeteam_team01\" placeholder=\"Name for Team 01\" required> </div> <div class=\"form-group\"> <input type=\"text\" class=\"form-control\" id=\"changeteam_team02\" placeholder=\"Name for Team 02\" required> </div> <button type=\"button\" class=\"btn btn-success\" onclick=\"changeTeamname("+serverid+")\">Submit</button> </form> </div> </div> </div> <div class=\"col-sm\"> <div class=\"card\"> <h5 class=\"card-header\">Change Flags</h5> <div class=\"card-body\"> <form> <div class=\"form-group\"> <input type=\"text\" class=\"form-control\" id=\"changeflag_team01\" placeholder=\"Flag for Team 01\" required> </div> <div class=\"form-group\"> <input type=\"text\" class=\"form-control\" id=\"changeflag_team02\" placeholder=\"Flag for Team 02\" required> </div> <button type=\"button\" class=\"btn btn-success\" onclick=\"changeFlag("+serverid+")\">Submit</button> </form> </div> </div> </div> <div class=\"col-sm\"> <div class=\"card\"> <h5 class=\"card-header\">Change Map</h5> <div class=\"card-body\"> <form> <div class=\"form-group\"> <input type=\"text\" class=\"form-control\" id=\"changemap\" placeholder=\"Map name\"> </div> <button type=\"button\" class=\"btn btn-success\" onclick=\"changeMap("+serverid+")\">Submit</button> </form> </div> </div> </div> <div class=\"col-sm\"> <div class=\"card\"> <h5 class=\"card-header\">Change Status</h5> <div class=\"card-body\"> <form> <div class=\"form-group\"> <input type=\"text\" class=\"form-control\" id=\"changestatus_txt\" placeholder=\"Text\"> </div> <div class=\"form-group\"> <input type=\"text\" class=\"form-control\" id=\"changestatus_team01\" placeholder=\"Status for Team 01\" required> </div> <div class=\"form-group\"> <input type=\"text\" class=\"form-control\" id=\"changestatus_team02\" placeholder=\"Status for Team 02\" required> </div> <button type=\"button\" class=\"btn btn-success\" onclick=\"changeStatus("+serverid+")\">Submit</button> </form> </div> </div> </div> </div>"
}

const changeTeamname = (serverid) => {
    instance.post('changeTeamname/'+serverid, {
        "team": 1,
	    "name": document.getElementById("changeteam_team01").value,
	    "key": localStorage.getItem("user_token")
    })
    .then(response => {
        const respmesssage = response.data;
        console.log(respmesssage);
        var obj = JSON.parse(JSON.stringify(respmesssage));
        if (obj['http_code'] == 200){
            toastr["success"]("Teamname updated for Team 01 on Server " + serverid);
        } else {
            toastr["error"]("Something went wrong");
        }
    })
    .catch(error => {
        console.error(error);
        toastr["error"]("Something went wrong... sorry :(");
    });

    instance.post('changeTeamname/'+serverid, {
        "team": 2,
	    "name": document.getElementById("changeteam_team02").value,
	    "key": localStorage.getItem("user_token")
    })
    .then(response => {
        const respmesssage = response.data;
        console.log(respmesssage);
        var obj = JSON.parse(JSON.stringify(respmesssage));
        if (obj['http_code'] == 200){
            toastr["success"]("Teamname updated for Team 02 on Server " + serverid);
        } else {
            toastr["error"]("Something went wrong");
        }
    })
    .catch(error => {
        console.error(error);
        toastr["error"]("Something went wrong... sorry :(");
    });
}

const changeFlag = (serverid) => {

}

const changeMap = (serverid) => {

}

const changeStatus = (serverid) => {

}