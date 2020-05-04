const instance = axios.create({
    baseURL: settings.url,
    timeout: 1000
});

const checkLoginStatus = (url) => {
    if (localStorage.getItem("user_token") === null) {
        window.location.replace(url+"site/login");
    } else {
        //<a class="dropdown-item" href="#">Action</a>
        let dropdownmenu = document.getElementById("serverList");
        instance.get('getServers')
            .then(response => {
                const respmesssage = response.data;
                console.log(respmesssage);
                var obja = JSON.parse(JSON.stringify(respmesssage));
                //dropdownmenu.innerHTML += "<a class=\"dropdown-item\" href=\"#\" onclick=\"displayServer(" + obj.server_number + ")\">"+obj.server_name+"</a>"
                obja.forEach(function (item) {
                    dropdownmenu.innerHTML += "<a class=\"dropdown-item\" href=\"#\" onclick=\"displayServer(" + item.server_number + ")\">" + item.server_name + " (#"+item.server_number +")</a>"
                });

            })
            .catch(error => {
                console.error(error);
                toastr["error"]("Something went wrong... sorry :(");
            });
            displayOverview();
    }
}

const displayServer = (serverid) => {
    let container = document.getElementById("display-container");
    container.innerHTML = "<div class=\"row\"> <div class=\"col-sm\" id=\"serverNumber\"> Selected server is #" + serverid + "</div> </div> <div class=\"row mt-3\"> <div class=\"col-sm\"> <div class=\"card\"> <h5 class=\"card-header\">Change Teamnames</h5> <div class=\"card-body\"> <form> <div class=\"form-group\"> <input type=\"text\" class=\"form-control\" id=\"changeteam_team01\" placeholder=\"Name for Team 01\" required=\"true\"> </div> <div class=\"form-group\"> <input type=\"text\" class=\"form-control\" id=\"changeteam_team02\" placeholder=\"Name for Team 02\" required=\"true\"> </div> <button type=\"button\" class=\"btn btn-success\" onclick=\"changeTeamname(" + serverid + ")\">Submit</button> </form> </div> </div> </div> </div> <div class=\"row mt-3\"> <div class=\"col-sm\"> <div class=\"card\"> <h5 class=\"card-header\">Change Flags</h5> <div class=\"card-body\"> <form> <div class=\"form-group\"><label for=\"changeflag_team01\">Flag for team 01</label><select class=\"selectpicker\" id=\"changeflag_team01\" data-live-search=\"true\" data-style=\"btn-primary\"></select></div> <div class=\"form-group\"> <label for=\"changeflag_team02\">Flag for team 02</label><select class=\"selectpicker\" id=\"changeflag_team02\" data-live-search=\"true\" data-style=\"btn-primary\"></select></div> <button type=\"button\" class=\"btn btn-success\" onclick=\"changeFlag(" + serverid + ")\">Submit</button> </form> </div> </div> </div> </div> <div class=\"row mt-3\"> <div class=\"col-sm\"> <div class=\"card\"> <h5 class=\"card-header\">Change Map</h5> <div class=\"card-body\"> <form> <div class=\"form-group\"> <label for=\"changemap\">Maps</label><select class=\"selectpicker\" id=\"changemap\" data-live-search=\"true\" data-style=\"btn-primary\"></select></div> <button type=\"button\" class=\"btn btn-success\" onclick=\"changeMap(" + serverid + ")\">Submit</button> </form> </div> </div> </div> </div> <div class=\"row mt-3\"> <div class=\"col-sm\"> <div class=\"card\"> <h5 class=\"card-header\">Change Status</h5> <div class=\"card-body\"> <form> <div class=\"form-group\"> <input type=\"text\" class=\"form-control\" id=\"changestatus_txt\" placeholder=\"Text\"> </div> <div class=\"form-group\"> <input type=\"text\" class=\"form-control\" id=\"changestatus_team01\" placeholder=\"Status for Team 01\" required=\"true\"> </div> <div class=\"form-group\"> <input type=\"text\" class=\"form-control\" id=\"changestatus_team02\" placeholder=\"Status for Team 02\" required=\"true\"> </div> <button type=\"button\" class=\"btn btn-success\" onclick=\"changeStatus(" + serverid + ")\">Submit</button> </form> </div> </div> </div> </div>"

    document.getElementById("changeflag_team01").innerHTML = "<option value=\"AD\">AD - Andorra</option> <option value=\"AE\">AE - United Arab Emirates</option> <option value=\"AF\">AF - Afghanistan</option> <option value=\"AG\">AG - Antigua and Barbuda</option> <option value=\"AI\">AI - Anguilla</option> <option value=\"AL\">AL - Albania</option> <option value=\"AM\">AM - Armenia</option> <option value=\"AO\">AO - Angola</option> <option value=\"AQ\">AQ - Antarctica</option> <option value=\"AR\">AR - Argentina</option> <option value=\"AS\">AS - American Samoa</option> <option value=\"AT\">AT - Austria</option> <option value=\"AU\">AU - Australia</option> <option value=\"AW\">AW - Aruba</option> <option value=\"AX\">AX - Ă…land Islands</option> <option value=\"AZ\">AZ - Azerbaijan</option> <option value=\"BA\">BA - Bosnia and Herzegovina</option> <option value=\"BB\">BB - Barbados</option> <option value=\"BD\">BD - Bangladesh</option> <option value=\"BE\">BE - Belgium</option> <option value=\"BF\">BF - Burkina Faso</option> <option value=\"BG\">BG - Bulgaria</option> <option value=\"BH\">BH - Bahrain</option> <option value=\"BI\">BI - Burundi</option> <option value=\"BJ\">BJ - Benin</option> <option value=\"BL\">BL - Saint BarthĂ©lemy</option> <option value=\"BM\">BM - Bermuda</option> <option value=\"BN\">BN - BruneiDarussalam</option> <option value=\"BO\">BO - Bolivia,Plurinational State of</option> <option value=\"BQ\">BQ - Bonaire,Sint Eustatius and Saba</option> <option value=\"BR\">BR - Brazil</option> <option value=\"BS\">BS - Bahamas</option> <option value=\"BT\">BT - Bhutan</option> <option value=\"BV\">BV - Bouvet Island</option> <option value=\"BW\">BW - Botswana</option> <option value=\"BY\">BY - Belarus</option> <option value=\"BZ\">BZ - Belize</option> <option value=\"CA\">CA - Canada</option> <option value=\"CC\">CC - Cocos (Keeling) Islands</option> <option value=\"CD\">CD - Congo, theDemocratic Republic of the</option> <option value=\"CF\">CF - Central African Republic</option> <option value=\"CG\">CG - Congo</option> <option value=\"CH\">CH - Switzerland</option> <option value=\"CI\">CI - CĂ´te dâ€™Ivoire</option> <option value=\"CK\">CK - Cook Islands</option> <option value=\"CL\">CL - Chile</option> <option value=\"CM\">CM - Cameroon</option> <option value=\"CN\">CN - China</option> <option value=\"CO\">CO - Colombia</option> <option value=\"CR\">CR - Costa Rica</option> <option value=\"CU\">CU - Cuba</option> <option value=\"CV\">CV - Cabo Verde</option> <option value=\"CW\">CW - CuraĂ§ao</option> <option value=\"CX\">CX - ChristmasIsland</option> <option value=\"CY\">CY - Cyprus</option> <option value=\"CZ\">CZ - Czech Republic</option> <option value=\"DE\">DE - Germany</option> <option value=\"DJ\">DJ - Djibouti</option> <option value=\"DK\">DK - Denmark</option> <option value=\"DM\">DM - Dominica</option> <option value=\"DO\">DO - Dominican Republic</option> <option value=\"DZ\">DZ - Algeria</option> <option value=\"EC\">EC - Ecuador</option> <option value=\"EE\">EE - Estonia</option> <option value=\"EG\">EG - Egypt</option> <option value=\"EH\">EH - Western Sahara</option> <option value=\"ER\">ER - Eritrea</option> <option value=\"ES\">ES - Spain</option> <option value=\"ET\">ET - Ethiopia</option> <option value=\"FI\">FI - Finland</option> <option value=\"FJ\">FJ - Fiji</option> <option value=\"FK\">FK - FalklandIslands (Malvinas)</option> <option value=\"FM\">FM - Micronesia, Federated States of</option> <option value=\"FO\">FO - Faroe Islands</option> <option value=\"FR\">FR - France</option> <option value=\"GA\">GA - Gabon</option> <option value=\"GB\">GB - United Kingdom of Great Britain and Northern Ireland</option> <option value=\"GD\">GD - Grenada</option> <option value=\"GE\">GE - Georgia</option> <option value=\"GF\">GF - French Guiana</option> <option value=\"GG\">GG - Guernsey</option> <option value=\"GH\">GH - Ghana</option> <option value=\"GI\">GI - Gibraltar</option> <option value=\"GL\">GL - Greenland</option> <option value=\"GM\">GM - Gambia</option> <option value=\"GN\">GN - Guinea</option> <option value=\"GP\">GP - Guadeloupe</option> <option value=\"GQ\">GQ - Equatorial Guinea</option> <option value=\"GR\">GR - Greece</option> <option value=\"GS\">GS - South Georgia and the South Sandwich Islands</option> <option value=\"GT\">GT - Guatemala</option> <option value=\"GU\">GU - Guam</option> <option value=\"GW\">GW - Guinea-Bissau</option> <option value=\"GY\">GY - Guyana</option> <option value=\"HK\">HK - Hong Kong</option> <option value=\"HM\">HM - HeardIsland and McDonald Islands</option> <option value=\"HN\">HN - Honduras</option> <option value=\"HR\">HR - Croatia</option> <option value=\"HT\">HT - Haiti</option> <option value=\"HU\">HU - Hungary</option> <option value=\"ID\">ID - Indonesia</option> <option value=\"IE\">IE - Ireland</option> <option value=\"IL\">IL - Israel</option> <option value=\"IM\">IM - Isle of Man</option> <option value=\"IN\">IN - India</option> <option value=\"IO\">IO - British Indian Ocean Territory</option> <option value=\"IQ\">IQ - Iraq</option> <option value=\"IR\">IR - Iran, Islamic Republic of</option> <option value=\"IS\">IS - Iceland</option> <option value=\"IT\">IT - Italy</option> <option value=\"JE\">JE - Jersey</option> <option value=\"JM\">JM - Jamaica</option> <option value=\"JO\">JO - Jordan</option> <option value=\"JP\">JP - Japan</option> <option value=\"KE\">KE - Kenya</option> <option value=\"KG\">KG - Kyrgyzstan</option> <option value=\"KH\">KH - Cambodia</option> <option value=\"KI\">KI - Kiribati</option> <option value=\"KM\">KM - Comoros</option> <option value=\"KN\">KN - Saint Kitts and Nevis</option> <option value=\"KP\">KP - Korea, Democratic Peopleâ€™s Republic of</option> <option value=\"KR\">KR - Korea,Republic of</option> <option value=\"KW\">KW - Kuwait</option> <option value=\"KY\">KY - Cayman Islands</option> <option value=\"KZ\">KZ - Kazakhstan</option> <option value=\"LA\">LA - Lao Peopleâ€™s Democratic Republic</option> <option value=\"LB\">LB - Lebanon</option> <option value=\"LC\">LC - Saint Lucia</option> <option value=\"LI\">LI - Liechtenstein</option> <option value=\"LK\">LK - Sri Lanka</option> <option value=\"LR\">LR - Liberia</option> <option value=\"LS\">LS - Lesotho</option> <option value=\"LT\">LT - Lithuania</option> <option value=\"LU\">LU - Luxembourg</option> <option value=\"LV\">LV - Latvia</option> <option value=\"LY\">LY - Libya</option> <option value=\"MA\">MA - Morocco</option> <option value=\"MC\">MC - Monaco</option> <option value=\"MD\">MD - Moldova,Republic of</option> <option value=\"ME\">ME - Montenegro</option> <option value=\"MF\">MF - Saint Martin (French part)</option> <option value=\"MG\">MG - Madagascar</option> <option value=\"MH\">MH - Marshall Islands</option> <option value=\"MK\">MK - Macedonia,the former Yugoslav Republic of</option> <option value=\"ML\">ML - Mali</option> <option value=\"MM\">MM - Myanmar</option> <option value=\"MN\">MN - Mongolia</option> <option value=\"MO\">MO - Macao</option> <option value=\"MP\">MP - Northern Mariana Islands</option> <option value=\"MQ\">MQ - Martinique</option> <option value=\"MR\">MR - Mauritania</option> <option value=\"MS\">MS - Montserrat</option> <option value=\"MT\">MT - Malta</option> <option value=\"MU\">MU - Mauritius</option> <option value=\"MV\">MV - Maldives</option> <option value=\"MW\">MW - Malawi</option> <option value=\"MX\">MX - Mexico</option> <option value=\"MY\">MY - Malaysia</option> <option value=\"MZ\">MZ - Mozambique</option> <option value=\"NA\">NA - Namibia</option> <option value=\"NC\">NC - New Caledonia</option> <option value=\"NE\">NE - Niger</option> <option value=\"NF\">NF - Norfolk Island</option> <option value=\"NG\">NG - Nigeria</option> <option value=\"NI\">NI - Nicaragua</option> <option value=\"NL\">NL - Netherlands</option> <option value=\"NO\">NO - Norway</option> <option value=\"NP\">NP - Nepal</option> <option value=\"NR\">NR - Nauru</option> <option value=\"NU\">NU - Niue</option> <option value=\"NZ\">NZ - New Zealand</option> <option value=\"OM\">OM - Oman</option> <option value=\"PA\">PA - Panama</option> <option value=\"PE\">PE - Peru</option> <option value=\"PF\">PF - French Polynesia</option> <option value=\"PG\">PG - Papua NewGuinea</option> <option value=\"PH\">PH - Philippines</option> <option value=\"PK\">PK - Pakistan</option> <option value=\"PL\">PL - Poland</option> <option value=\"PM\">PM - Saint Pierre and Miquelon</option> <option value=\"PN\">PN - Pitcairn</option> <option value=\"PR\">PR - Puerto Rico</option> <option value=\"PS\">PS - Palestine, State of</option> <option value=\"PT\">PT - Portugal</option> <option value=\"PW\">PW - Palau</option> <option value=\"PY\">PY - Paraguay</option> <option value=\"QA\">QA - Qatar</option> <option value=\"RE\">RE - RĂ©union</option> <option value=\"RO\">RO - Romania</option> <option value=\"RS\">RS - Serbia</option> <option value=\"RU\">RU - RussianFederation</option> <option value=\"RW\">RW - Rwanda</option> <option value=\"SA\">SA - Saudi Arabia</option> <option value=\"SB\">SB - SolomonIslands</option> <option value=\"SC\">SC - Seychelles</option> <option value=\"SD\">SD - Sudan</option> <option value=\"SE\">SE - Sweden</option> <option value=\"SG\">SG - Singapore</option> <option value=\"SH\">SH - Saint Helena, Ascension and Tristanda Cunha</option> <option value=\"SI\">SI - Slovenia</option> <option value=\"SJ\">SJ - Svalbard and Jan Mayen</option> <option value=\"SK\">SK - Slovakia</option> <option value=\"SL\">SL - Sierra Leone</option> <option value=\"SM\">SM - San Marino</option> <option value=\"SN\">SN - Senegal</option> <option value=\"SO\">SO - Somalia</option> <option value=\"SR\">SR - Suriname</option> <option value=\"SS\">SS - South Sudan</option> <option value=\"ST\">ST - Sao Tome and Principe</option> <option value=\"SV\">SV - El Salvador</option> <option value=\"SX\">SX - Sint Maarten(Dutch part)</option> <option value=\"SY\">SY - Syrian ArabRepublic</option> <option value=\"SZ\">SZ - Swaziland</option> <option value=\"TC\">TC - Turks and Caicos Islands</option> <option value=\"TD\">TD - Chad</option> <option value=\"TF\">TF - French Southern Territories</option> <option value=\"TG\">TG - Togo</option> <option value=\"TH\">TH - Thailand</option> <option value=\"TJ\">TJ - Tajikistan</option> <option value=\"TK\">TK - Tokelau</option> <option value=\"TL\">TL - Timor-Leste</option> <option value=\"TM\">TM - Turkmenistan</option> <option value=\"TN\">TN - Tunisia</option> <option value=\"TO\">TO - Tonga</option> <option value=\"TR\">TR - Turkey</option> <option value=\"TT\">TT - Trinidad and Tobago</option> <option value=\"TV\">TV - Tuvalu</option> <option value=\"TW\">TW - Taiwan,Province of China</option> <option value=\"TZ\">TZ - Tanzania,United Republic of</option> <option value=\"UA\">UA - Ukraine</option> <option value=\"UG\">UG - Uganda</option> <option value=\"UM\">UM - United States Minor Outlying Islands</option> <option value=\"US\">US - United Statesof America</option> <option value=\"UY\">UY - Uruguay</option> <option value=\"UZ\">UZ - Uzbekistan</option> <option value=\"VA\">VA - Holy See</option> <option value=\"VC\">VC - SaintVincent and the Grenadines</option> <option value=\"VE\">VE - Venezuela,Bolivarian Republic of</option> <option value=\"VG\">VG - Virgin Islands, British</option> <option value=\"VI\">VI - Virgin Islands, U.S.</option> <option value=\"VN\">VN - Viet Nam</option> <option value=\"VU\">VU - Vanuatu</option> <option value=\"WF\">WF - Wallis and Futuna</option> <option value=\"WS\">WS - Samoa</option> <option value=\"YE\">YE - Yemen</option> <option value=\"YT\">YT - Mayotte</option> <option value=\"ZA\">ZA - South Africa</option> <option value=\"ZM\">ZM - Zambia</option> <option value=\"ZW\">ZW - Zimbabwe</option>";

    document.getElementById("changeflag_team02").innerHTML = document.getElementById("changeflag_team01").innerHTML

    document.getElementById("changemap").innerHTML = "<option value=\"de_cache\">Cache</option> <option value=\"de_dust2\">Dust II</option> <option value=\"de_mirage\">Mirage</option> <option value=\"de_overpass\">Overpass</option> <option value=\"de_nuke\">Nuke</option> <option value=\"de_inferno\">Inferno</option> <option value=\"de_train\">Train</option> <option value=\"de_cbble\">Cobblestone</option> <option value=\"de_canals\">Canals</option> <option value=\"de_subzero\">Subzero</option> <option value=\"de_shortdust\">Shortdust</option> <option value=\"de_shortnuke\">Shortnuke</option> <option value=\"de_shorttrain\">Shorttrain (Removed from game)</option> <option value=\"cs_agency\">Agency</option> <option value=\"cs_assault\">Assault</option> <option value=\"cs_italy\">Italy</option> <option value=\"cs_office\">Office</option> <option value=\"de_austria\">Austria</option> <option value=\"de_biome\">Biome</option> <option value=\"ar_baggage\">Baggage</option> <option value=\"de_lake\">Lake</option> <option value=\"ar_monastery\">Monastery</option> <option value=\"de_safehouse\">Safehouse</option> <option value=\"ar_shoots\">Shoots</option> <option value=\"de_stmarc\">St. Marc</option> <option value=\"de_bank\">Bank</option> <option value=\"de_sugarcane\">Sugarcane</option> <option value=\"ar_dizzy\">Dizzy</option> <option value=\"gd_rialto\">Rialto</option>";

    $('.selectpicker').selectpicker({
    });
}

const changeTeamname = (serverid) => {
    if (document.getElementById("changeteam_team01").value === "" || document.getElementById("changeteam_team02").value === "") {
        toastr["error"]("Empty input!");
    } else {
        instance.post('changeTeamname/' + serverid, {
            "team": 1,
            "name": document.getElementById("changeteam_team01").value,
            "key": localStorage.getItem("user_token")
        })
            .then(response => {
                const respmesssage = response.data;
                console.log(respmesssage);
                var obj = JSON.parse(JSON.stringify(respmesssage));
                if (obj['http_code'] == 200) {
                    toastr["success"]("Teamname updated for Team 01 on Server " + serverid);
                } else {
                    toastr["error"]("Something went wrong");
                }
            })
            .catch(error => {
                console.error(error);
                toastr["error"]("Something went wrong... sorry :(");
            });

        instance.post('changeTeamname/' + serverid, {
            "team": 2,
            "name": document.getElementById("changeteam_team02").value,
            "key": localStorage.getItem("user_token")
        })
            .then(response => {
                const respmesssage = response.data;
                console.log(respmesssage);
                var obj = JSON.parse(JSON.stringify(respmesssage));
                if (obj['http_code'] == 200) {
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
}

const changeFlag = (serverid) => {
    instance.post('changeFlag/' + serverid, {
        "team": 1,
        "country": document.getElementById("changeflag_team01").value,
        "key": localStorage.getItem("user_token")
    })
        .then(response => {
            const respmesssage = response.data;
            console.log(respmesssage);
            var obj = JSON.parse(JSON.stringify(respmesssage));
            if (obj['http_code'] == 200) {
                toastr["success"]("Flag updated for Team 01 on Server " + serverid);
            } else {
                toastr["error"]("Something went wrong");
            }
        })
        .catch(error => {
            console.error(error);
            toastr["error"]("Something went wrong... sorry :(");
        });

    instance.post('changeFlag/' + serverid, {
        "team": 2,
        "country": document.getElementById("changeflag_team02").value,
        "key": localStorage.getItem("user_token")
    })
        .then(response => {
            const respmesssage = response.data;
            console.log(respmesssage);
            var obj = JSON.parse(JSON.stringify(respmesssage));
            if (obj['http_code'] == 200) {
                toastr["success"]("Flag updated for Team 02 on Server " + serverid);
            } else {
                toastr["error"]("Something went wrong");
            }
        })
        .catch(error => {
            console.error(error);
            toastr["error"]("Something went wrong... sorry :(");
        });
}

const changeMap = (serverid) => {
    instance.post('changeMap/' + serverid, {
        "map": document.getElementById("changemap").value,
        "key": localStorage.getItem("user_token")
    })
        .then(response => {
            const respmesssage = response.data;
            console.log(respmesssage);
            var obj = JSON.parse(JSON.stringify(respmesssage));
            if (obj['http_code'] == 200) {
                toastr["success"]("Map changed on Server " + serverid);
            } else {
                toastr["error"]("Something went wrong");
            }
        })
        .catch(error => {
            console.error(error);
            toastr["error"]("Something went wrong... sorry :(");
        });
}

const changeStatus = (serverid) => {

    if (document.getElementById("changestatus_team01").value === "" || document.getElementById("changestatus_team02").value === "") {
        toastr["error"]("Empty input!");
    } else {
        instance.post('changeStats/' + serverid, {
            "txt": document.getElementById("changestatus_txt").value,
            "team1": document.getElementById("changestatus_team01").value,
            "team2": document.getElementById("changestatus_team02").value,
            "key": localStorage.getItem("user_token")
        })
            .then(response => {
                const respmesssage = response.data;
                console.log(respmesssage);
                var obj = JSON.parse(JSON.stringify(respmesssage));
                if (obj['http_code'] == 200) {
                    toastr["success"]("Status updated on Server " + serverid);
                } else {
                    toastr["error"]("Something went wrong");
                }
            })
            .catch(error => {
                console.error(error);
                toastr["error"]("Something went wrong... sorry :(");
            });
    }

}

const logout = () => {
    localStorage.clear();
    location.reload();
}

const displayOverview = () => {
    instance.get('getPoints')
    .then(response => {
        const respmesssage = response.data;
        console.log(respmesssage);
        var obja = JSON.parse(JSON.stringify(respmesssage));
        //dropdownmenu.innerHTML += "<a class=\"dropdown-item\" href=\"#\" onclick=\"displayServer(" + obj.server_number + ")\">"+obj.server_name+"</a>"
        let container = document.getElementById("display-container");
        container.innerHTML = "<h1>Overview</h1><table class=\"table\"> <thead> <tr> <th scope=\"col\">Server #</th> <th scope=\"col\">CT points</th> <th scope=\"col\">T points</th> </tr> </thead> <tbody id=\"scorekeeper\"></tbody> </table>";
        let table = document.getElementById("scorekeeper");
        obja.forEach(function (item) {
            table.innerHTML += "<tr><th scope=\"row\">" + item.server + "</th><td>" + item.ctpoint + "</td><td>" + item.tpoint + "</td></tr>"
        });

    })
    .catch(error => {
        console.error(error);
        toastr["error"]("Something went wrong... sorry :(");
    });
}

const displayUserCreation = () => {
    let container = document.getElementById("display-container");
    container.innerHTML = "<h1>Add User</h1><form> <div class=\"form-group\"> <input type=\"text\" class=\"form-control\" id=\"adduser_username\" placeholder=\"Username\" required> </div> <div class=\"form-group\"> <input type=\"password\" class=\"form-control\" id=\"adduser_password\" placeholder=\"Password\" required> </div> <button type=\"button\" class=\"btn btn-success\" onclick=\"addUser()\">Add user</button> </form>";
}

const addUser = () => {
    if (document.getElementById("adduser_username").value === "" || document.getElementById("adduser_password").value === "") {
        toastr["error"]("Empty input!");
    } else {
        instance.post('createUser', {
            "username": document.getElementById("adduser_username").value,
            "password": document.getElementById("adduser_password").value,
            "key": localStorage.getItem("user_token")
        })
            .then(response => {
                const respmesssage = response.data;
                console.log(respmesssage);
                var obj = JSON.parse(JSON.stringify(respmesssage));
                if (obj['http_code'] == 200) {
                    toastr["success"]("User created!");
                } else {
                    toastr["error"]("Something went wrong");
                }
            })
            .catch(error => {
                console.error(error);
                toastr["error"]("Something went wrong... sorry :(");
            });
    }
}