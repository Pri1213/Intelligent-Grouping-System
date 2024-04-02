/***********************************************************
 *  FCFBI application V1.0
 *  Copyright 2022 
 *  Authors: -
***********************************************************/

const app_name = 'Le HUB';   // holds the application name
const event = new Event('spa_loaded'); // spa loaded event
var spa_loaded = null;
let debug = true; // set error logging to true
let date_pickers = {};  // save date pickers instances globally
var session = window.sessionStorage;
var local_storage = localStorage;
var dz_instance_obj = null;
let startup_page = "spa-permissions";
let fnx_table = null;
let _user_avatar_login = null;

/*
    HELPERS
*/
var app = {

    init: function (page_name) {
        session.clear();

        $("[data-role='app_name']").text(app_name);
        $(`[data-spa='${page_name}']`).click();
        session.setItem("page_theme", "dark_mode");
    },

    renderer: {
        toggle: function(fsel, ssel, affectDOM = true){
            let spa_target = $(ssel).attr("data-spa-page");

            let spa_pre_checks = {
                'spa-content-asset_list': {
                    fn: () => {
                        return (session.getItem('asset_in_view') === null);
                    },
                    err: 'Access rule violation, choose an asset first !' 
                },
                'spa-content-summary-building':{
                    fn: () => {
                        return (session.getItem('building_in_view') === null);
                    },
                    err: 'Access rule violation, choose an building first !' 
                }
            }

            if(spa_pre_checks.hasOwnProperty(spa_target)){
                if(spa_pre_checks[spa_target].fn()){
                    Toastify({
                      text: spa_pre_checks[spa_target].err,
                      className: "err_toast",
                      gravity: "bottom", // `top` or `bottom`
                    }).showToast();
                    return;
                }
            }

            if(affectDOM){

                if(!$(`[data-spa-page='${spa_loaded}'] [data-role='dsp-tiles-drilldown']`).hasClass('no-display') && spa_loaded !== null){
                    $(`[data-spa-page='${spa_loaded}'] [data-role="close_drilldown"]`).click();
                }

                $(".dsb-filters").removeClass("no-display");
                $(fsel).addClass("no-display");
                $(ssel).removeClass("no-display");

                let v_ = $(`[data-spa='${spa_target}']`).parent();

                // GLOBAL DOM FACTORY RESET
                $("[data-role='dsp-filters'] .dsb-filters").removeClass("dsp-filters-map");
                $("[data-role='dsp-filters']").removeClass("col-lg-1");
                $("[data-role='dsp-filters']").addClass("col-lg-6");
                $(".dsb-container, .dsb-filters").removeClass("no-box-shadow");
                $("[data-role='dsp-nav']").removeAttr("style");
                $("[data-role='dsp-filters']").removeClass("no-display");
                $("[data-role='report_export_data']").addClass("no-display");
                $("[data-role='report_drilldown_col_sel']").addClass("no-display");
                $(".ov_bs").addClass("no-display");
                $("[data-role='dsp-tiles-summary']").removeClass("no-display");
                $("#csx-hide-adv-filters").addClass("no-display");
                $("#csx-show-adv-filters").removeClass("no-display");

                if(spa_target === 'spa-content-site'){
                    $("[data-role='dsp-tiles-summary']").removeClass("no-display");
                }else if(spa_target === 'spa-content-map') {
                    $("[data-role='dsp-tiles-summary']").addClass("no-display");
                    $("#dsp_map").addClass("no-display");
                    $("#csx-dt-preloader-map").removeClass("no-display");
                    $(".dsb-container, .dsb-filters").addClass("no-box-shadow");
                    $("[data-role='dsp-filters'] .dsb-filters").addClass("dsp-filters-map");
                    $("[data-role='dsp-filters']").removeClass("col-lg-6");
                    $("[data-role='dsp-filters']").addClass("col-lg-1");
                    $("[data-role='dsp-nav']").css({position: 'fixed', width: 'inherit', 'z-index': '2'});
                }

                if( v_.attr("data-collapse-element") !== undefined){
                    $("[data-spa]").removeClass("dsp-sub-nav-item-active dsp-active");
                    $(`[data-spa='${spa_target}']`).addClass("dsp-sub-nav-item-active");

                    let z_ = $(`[data-dsp-collapse-target='${v_.attr("data-collapse-element")}']`);
                    $(`[data-spa='${z_.attr("data-spa")}']`).toggleClass("dsp-active");
                    $("[data-spa] span").removeClass("dsp-nav-item-active").addClass("dsp-nav-item-inactive");
                    $(`[data-spa='${z_.attr("data-spa")}'] span`).removeClass("dsp-nav-item-inactive").addClass("dsp-nav-item-active");
                    $(`[data-collapse-element]`).addClass("dsp-hideshow-subitem");
                    $(v_).removeClass("dsp-hideshow-subitem");

                }else{
                    $("[data-spa]").removeClass("dsp-sub-nav-item-active dsp-active");
                    $(`[data-spa='${spa_target}']`).toggleClass("dsp-active");
                    $("[data-spa] span").removeClass("dsp-nav-item-active").addClass("dsp-nav-item-inactive");
                    $(`[data-spa='${spa_target}'] span`).removeClass("dsp-nav-item-inactive").addClass("dsp-nav-item-active");
                    $(`[data-collapse-element]`).addClass("dsp-hideshow-subitem");
                }

                $("[data-role='csx-bread']").text($(`[data-spa='${spa_target}'] p`).text());
                //$("title").text(`· Le HUB · ${$(`[data-spa='${spa_target}'] p`).text()}`);
            }
            
            setTimeout(function(){
                $(ssel).trigger('spaloaded');
                session.setItem('spa_loaded', spa_target);
                spa_loaded = spa_target;

                app.page.toast("SUCCESS", "Page is loading, hold a cup of coffee, wait for the loaders ☕", 5000)
            }, 0);

            $(function () {
              $('[data-toggle="tooltip"]').tooltip()
            })
        }
    },

    protocol: {
        ajax: function (url, data, parameters, type = 'GET'){
            $.ajax({ url: url, data: data, type: type})
            .done(function(data){
                if(parameters.hasOwnProperty('o'))
                    parameters.c(data, ...parameters.o);
                else{
                    parameters.c(data);
                }
            });
        }
    },

    page: {
        dashboard:{
            init_dropzone: function (sel) {
                if(dz_instance_obj !== null){
                    dz_instance_obj.destroy();
                    dz_instance_obj = null;
                }

                var dz_cfg= {

                    autoProcessQueue: true,
                    uploadMultiple: false,
                    parallelUploads: 100,
                    maxFiles: 1,
                    acceptedFiles: "image/jpeg,image/png",
                    addRemoveLinks: false,
                    dictDefaultMessage: "<div class='d-flex flex-column align-items-center'><h1>Dropzone</h1><p class='csx-sm-font'>Want a new feel ?, drop an image 🔥</p></div>",

                    init: function() {
                        dz_instance_obj = this;

                        this.on("sendingmultiple", function() {
                            // Gets triggered when the form is actually being sent.
                            // Hide the success button or the complete form.
                        });

                        this.on("complete", function(files) {
                            // Gets triggered when the file is uploaded
                        });

                        this.on("success", function(file, response) {

                            let _p = JSON.parse(response);

                            if(_p.err === null){
                                dz_instance_obj.removeFile(file);
                                app.page.toast('SUCCESS', 'New background, feels good and nice 😏');
                                $("[data-overlay='background_dz_ov']").addClass("no-display");

                                if(_p.location !== null){
                                    let fnx = `url('dist\\${_p.location}')`.replaceAll("\\", "/");
                                    $(".csx_hero_banner").css("background-image", fnx);
                                    window.location.reload();
                                }
                            }else{ 
                                dz_instance_obj.removeFile(file); 
                                app.page.toast("ERR", _p.err, 5000);
                            }
                        });

                        this.on("error", function(file, response) {
                            app.page.toast("ERR", response);
                            dz_instance_obj.removeFile(file);
                        });

                        this.on("successmultiple", function(files, response) {
                            console.log(response);
                        });

                        this.on("errormultiple", function(file, response) {
                            app.page.toast("ERR", response);
                            dz_instance_obj.removeFile(file);
                        });

                        this.on("maxfilesexceeded", function(file){
                            dz_instance_obj.removeFile(file);
                            app.page.toast('ERR', 'Maximum upload image file size exceeded ( 10 MB )');
                        });
                    }
                     
                }

                var dz_instance = new Dropzone(sel, dz_cfg);
            }
        },

        get_translation_cfg: function (lang) {
            return new Promise((resolve, reject) => {
                app.protocol.ajax(
                    'dist/bridge.php',
                    { request_type: 'get_translation_cfg', lang: lang},
                    {c: (d) => {
                        if(app.helper.tryParseJSONObject(d))
                            resolve(JSON.parse(d));
                        else 
                            reject(false)
                    }}
                ); 
            })
        },

        mod_translation_cfg: function(lang, modded_cfg) {
            return new Promise((resolve, reject) => {
                app.protocol.ajax(
                    'dist/bridge.php',
                    { request_type: 'mod_translation_cfg', lang: lang, modded_cfg: modded_cfg},
                    {c: (d) => {
                        if(app.helper.tryParseJSONObject(d))
                            resolve(JSON.parse(d));
                        else 
                            reject(false)
                    }}, 
                    'POST'
                ); 
            })
        },

        toast: function (type, message, timeout = 2000) {
            $("[role='alert']").removeAttr("class").addClass("alert alert-pos");

            var alert_class = "warning_toast";
            switch(type){
                case "ERR":
                    alert_class = "err_toast";
                    break;
                case "SUCCESS":
                    alert_class = "success_toast";
                    break;
                case "WARNING":
                    alert_class = "warning_toast";
                    break;
                case "INFO":
                    alert_class = "info_toast";
                    break;
                default:
                    throw "Unknown alert type";
            }

            Toastify({
              text: message,
              className: alert_class,
              gravity: "bottom",
              duration: timeout
            }).showToast();
        },

        onrendered: function (callback) {
            return new Promise((resolve, reject) => {
                let handler = function () {
                    setTimeout(() => {
                        resolve(callback);
                    }, 1000);
                }

                window.removeEventListener('load', handler());
                window.addEventListener('load', handler());
            });
        },

        fillColors: function(amount){
            const colors = [
                "f94144", "f3722c", "f8961e", "f9844a", "f9c74f", "90be6d", "43aa8b", "4d908e", "577590", "277da1", "cb997e", "ddbea9", "ffe8d6", "b7b7a4", 
                "a5a58d", "6b705c", "0a9396", "94d2bd", "e9d8a6", "ee9b00", "ca6702", "bb3e03", "ae2012", "9b2226", "2a9d8f", "e9c46a", "f4a261", "e76f51", 
                "e63946", "f1faee", "a8dadc", "457b9d", "1d3557", "00b4d8", "99d98c", "ccd5ae", "f9844a", "e63946","f1faee","a8dadc","457b9d","1d3557","001219",
                "005f73","0a9396","94d2bd","e9d8a6","ee9b00","ca6702","bb3e03","ae2012","9b2226","03071e","370617","6a040f","9d0208","d00000","dc2f02","e85d04",
                "f48c06","faa307","ffba08","d9ed92","b5e48c","99d98c","76c893","52b69a","34a0a4","168aad","1a759f","1e6091","184e77","f94144","f3722c","f8961e",
                "f9844a","f9c74f","90be6d","43aa8b","4d908e","577590","277da1"
            ];

            var palette = [];
            for(let x = 0; x < amount; x++)
                palette.push(`#${colors[x]}`);

            return palette;
        },

        exportCanvas: function(canvas){
            $(canvas)[0].toBlob(function(blob) {
                var img = document.createElement('img'),
                url = URL.createObjectURL(blob);

                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = url;

                a.download = 'image.jpeg';
                document.body.appendChild(a);
                a.click();

                window.URL.revokeObjectURL(url);
                $(a).remove();
            });
        },

        export_file: function (path, file_name) {
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = path;

            a.download = file_name;
            document.body.appendChild(a);
            a.click();

            window.URL.revokeObjectURL(path);
            $(a).remove();
        },
        
        render_void_placeholder: function(sel_id, preloader_target, preloader_shadow, preloader_type){
            //unload empty loader first
            $(sel_id).closest(preloader_target).parent().find('.dsp-spa-chart-empty').remove();
            let clone_chart_preloader = $($(preloader_shadow)[0].outerHTML).removeClass("no-display");
            $(sel_id).closest(".dsp-spa-chart").addClass("no-display");
            $(clone_chart_preloader).insertAfter($(sel_id).closest(preloader_target));

            var _title = {
                chart: {
                    "#number_intervention": 'Intervention by date',
                    "#number_intervention_by_nature": 'Intervention by nature',
                    "#number_intervention_by_category": 'Intervention by category',
                    "#number_intervention_by_state": 'Intervention by status',
                    "#number_intervention_by_priority": 'Intervention by priority',
                    "#number_intervention_by_service_provider": 'Intervention by service provider',
                    "#asset_chart": 'Asset summary chart',
                    "#work_priority": 'Live work orders',
                    "#work_type": 'Overdue work orders',
                    "#finance_chart": 'Finance summary chart',
                    "#contractor_chart": 'Contractor summary chart',
                    "#fw_chart_details": 'Assets - reactive / planned',
                    "#fw_chart_planned_pie": 'Assets - no planned data',
                    "#fw_chart_planned_stackbar": 'Assets - no planned stack data',
                    "#fw_chart_reactive_pie": 'Assets - no reactive data',
                    "#fw_chart_reactive_stackbar": 'Assets - no reactive stack data',
                    "#fw_chart_regulatory_pie": 'Assets - no regulatory data',
                    "#fw_chart_regulatory_stackbar": 'Assets - no regulatory stack data'
                }
            };

            $(clone_chart_preloader).find("p").text(_title[preloader_type][sel_id]);

        },

        render_placeholder: function(sel_id, preloader_target, preloader_shadow){
            $(sel_id).closest(preloader_target).parent().find(preloader_shadow).remove();
            let clone_chart_preloader = $($(preloader_shadow)[0].outerHTML).removeClass("no-display");
            $(sel_id).closest(preloader_target).addClass("no-display");
            $(clone_chart_preloader).insertAfter($(sel_id).closest(preloader_target));
        },

        unload_placeholder: function(sel_id, preloader_target, preloader_shadow){
            $(sel_id).closest(preloader_target).removeClass("no-display");
            $(sel_id).closest(preloader_target).parent().find(preloader_shadow).remove();
        },

        render_datemask_field: function(cb){
            const date_format = [
                {name: null, mask: "iso_date"}, 
                {name: null, mask: "short_date"}, 
                {name: null, mask: "long_date"}, 
                {name: null, mask: 'dd-mm-yyyy'}, 
                {name: null, mask: 'dd/mm/yyyy'}
            ];

            for(let x in date_format){
                switch (date_format[x].mask){
                    case 'iso_date':
                        app.page.format_date(null, (data) => {
                            date_format[x].name = `${data.year}-${data.month}-${data.date}`
                        });
                        break;
                    case 'short_date':
                        app.page.format_date(null, (data) => {
                            date_format[x].name = `${data.month}-${data.date}-${data.year}`
                        });
                        break;
                    case 'long_date':
                        app.page.format_date(null, (data) => {
                            date_format[x].name = `${data.month_full} ${data.date} ${data.year}`
                        });
                        break;
                    case 'dd-mm-yyyy':
                        app.page.format_date(null, (data) => {
                            date_format[x].name = `${data.date}-${data.month}-${data.year}`
                        });
                        break;
                    case 'dd/mm/yyyy':
                        app.page.format_date(null, (data) => {
                            date_format[x].name = `${data.date}/${data.month}/${data.year}`
                        });
                        break;
                    default:
                        throw new Error('Undefined date format');
                }
            }

            return cb(date_format);
        },

        format_date: function (d, callback) {
            var date = new Date();

            if(d !== null)
                date.setTime(typeof d != 'int'?d:Date.parse(d));
            
            const month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

            callback ({
                min: (date.getMinutes() >= 10)?date.getMinutes():("0" + date.getMinutes()),
                hours: (date.getHours() >= 10)?date.getHours():("0" +date.getHours()),
                second: (date.getSeconds() >= 10)?date.getSeconds():("0" +date.getSeconds()),
                meridian: (date.getHours() >= 12)?"PM":"AM",
                month: ((date.getMonth() + 1) >= 10)?(date.getMonth() + 1):("0"+(date.getMonth() + 1)),
                month_full: month[date.getMonth()],
                date: (date.getDate() >= 10)?date.getDate():("0" + date.getDate()),
                year: date.getFullYear(),
                day: days[date.getDay()]
            });
        },

        pretty_print_digit: function(nStr){
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        },

        bind_date_pickers_to: function (selectors) {

            for(let x in selectors){
                date_pickers[x] = MCDatepicker.create({ 
                    el: `#${selectors[x]}`,
                    dateFormat: 'YYYY-MM-DD',
                    bodyType: 'inline'
                });
            }

        },

        tabletoarray: function (sel, only_header = true, only_visible_headers = false) {
            let theader = [];
            let tbody = [];

            /************* RETRIEVE ALL THE HEADERS **************/
            $(sel).find("thead th").each((i, e) => {
                if(only_visible_headers){
                    if(!$(e).hasClass("no-display"))
                        theader.push($(e).text());
                }else{
                    theader.push($(e).text());
                }
            });

            /************* RETRIEVE ALL THE DATA **************/
            if(only_header){
                $(sel).find("tbody tr").each((i, e) => {
                    let temp = [];
                    $(e).find("td").each((o, a) => {
                        temp.push($(a).text());
                    });
                    tbody.push(temp);
                });
            }

            return only_header?{'theader': theader}:{'theader': theader,'tbody': tbody}
        },

        get_sys_currency: function () {
            return new Promise((resolve, reject) => {
                app.protocol.ajax(
                    'dist/bridge.php',
                    { request_type: 'get_sys_currency'},
                    {c: (d) => {
                        if(app.helper.tryParseJSONObject(d))
                            resolve(JSON.parse(d)["currency"]);
                        else 
                            reject(false)
                    }}
                ); 
            })
        },

        get_report_conf: function () {
            return new Promise((resolve, reject) => {
                app.protocol.ajax(
                    'dist/bridge.php',
                    { request_type: 'get_report_conf'},
                    {c: (d) => {
                        if(app.helper.tryParseJSONObject(d))
                            resolve(JSON.parse(d));
                        else 
                            reject(false)
                    }}
                ); 
            })
        },

    },

    export: {
        saveBlobFile : function(file_name, file_type, data){
            return new Promise((resolve, reject) => {
                app.protocol.ajax(
                    (['pdf', 'xlsx'].includes(file_type)?'dist/report_generator.php':'dist/bridge.php'),
                    { request_type: 'upload_file', file_name: file_name, file_type: file_type, file_data: data},
                    {c: (data) => {
                        resolve(data);
                    }},
                    'POST'
                );
            }); 
        },

        csv: function (export_content, file_type, file_name) {
            return new Promise((resolve, reject) => {
                app.protocol.ajax(
                    'dist/bridge.php',
                    {request_type: 'export_csv', dataset: export_content, file_type: file_type, file_name: file_name},
                    {c: (data) => {
                        resolve(data);
                    }},
                    'POST'
                );
            }); 
        }
    },

    helper: {
        chunk: function(arr, chunkSize) {
            if (chunkSize <= 0) throw "Invalid chunk size";
            var R = [];
            for (var i=0,len=arr.length; i<len; i+=chunkSize)
                R.push(arr.slice(i,i+chunkSize));
            return R;
        },
        tryParseJSONObject: function (jsonString){
            try {
                var o = JSON.parse(jsonString);

                if (o && typeof o === "object") {
                    return o;
                }
            }
            catch (e) { }

            return false;
        },

        convertStringToHTML :function(html_string){
            const parser = new DOMParser();
            const html = parser.parseFromString(html_string, 'text/html');

            return html.body;

        } 
    },

    logger: {
        log: function(error_type, errors){
            app.protocol.ajax(
                'dist/bridge.php',
                { request_type: 'log_file', error_type: error_type, error_data: errors},
                {c: (d) => {
                    let parser = JSON.parse(d);
                    if(debug){
                        app.page.toast("WARNING", `error logged at ${parser.file_path}`);
                    }
                }},
                'POST'
            );
        }
    },

    req: {
        fetch: function(request_type, params){
            return new Promise((resolve, reject) => {
                let res = {
                    request_type: request_type,
                    ...params
                }
                
                app.protocol.ajax(
                    'dist/bridge.php',
                    res,
                    {c: (d) => {
                        if(app.helper.tryParseJSONObject(d)){
                            resolve(d);
                        }else{
                            reject(d);
                        }
                    }},
                    'POST'
                );
            });
        },
        api: function(url, params, http_method='GET'){
            return new Promise((resolve, reject) => {
                app.protocol.ajax(
                    url,
                    params,
                    {c: (d) => {
                        if(app.helper.tryParseJSONObject(JSON.stringify(d))){
                            resolve(d);
                        }else{
                            reject(d);
                        }
                    }},
                    http_method
                );
            });
        },
        async_form: function(uri, form_data){
            return new Promise((resolve, reject) => {
                $.ajax({
                    type: "POST",
                    url: `dist/bridge.php?${uri}`,
                    data: form_data,
                    contentType: false,
                    processData: false
                }).done(function(data){
                    if(app.helper.tryParseJSONObject(data)){
                        resolve(data);
                    }else{
                        reject(data);
                    }
                });
            });
        },
    },
    form: {
        validate_input: function(type, value){
            //object having different regex pattern for each input type
            const regex = {
                username: /^[a-zA-Z\s]+$/,
                password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*?])(?=.{8,})/,
                email: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,
                mobile_phone: /^((\+)33|0)[1-9](\d{2}){4}$/g,
                none: /.*/,
                number: /^[0-9]*$/,
                date: /([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/,
                // construct a regex from the previous password field
                confirm_password: new RegExp($("[name='reg_pwd']").val())
            };

            
            //throws an error if the input type does not have a regex pattern
            if(!regex.hasOwnProperty(type))
                throw `Given input type does not exist, type: ${type}`;

            //if field empty, evaluate the field as valid else test for regex pattern
            return (value == '')?false:regex[type].test(value);
        },

        toggle_input_state: function(input, state, err = null){
            //always remove previously injected element
            $(input).parent().find('.csx-error').remove();
            const input_type_exception = ['file', 'checkbox', 'hidden', 'radio', 'color', 'range'];

            //if input type is referenced as excluded for validation
            if(!state && !input_type_exception.includes($(input).attr('type'))){

                $(input).val($(input)[0].defaultValue);
                Toastify({
                  text: (err == null)?$(input).attr('data-error'):err,
                  className: "err_toast",
                  gravity: "bottom", // `top` or `bottom`
                }).showToast();

                $(input).data('input_valid', false);
            }else{
                $(input).data('input_valid', true);
            }
        },

        //check if a form is valid
        form_valid: function (form){
            var bools = [];
            const input_type_exception = ['file', 'checkbox', 'hidden', 'radio'];

            $(form).find('input').each(function(index, node){
                //Used the double-not operator to type cast the values to boolean
                if(!input_type_exception.includes($(node).attr('type'))){
                    bools.push(!!$(node).data('input_valid'));
                }
            });

            //evaluate the array (input state transformed as boolean based on validity)
            for(const bool of bools){
                if(!bool){
                    return false;
                }
            }

            return true;
        }
    },

    html_snapshot: function (sel, export_name, orientation) {
        var element = document.getElementById(sel);

        var opt = {
          margin:       0.5,
          filename:     export_name,
          image:        { type: 'jpeg', quality: 0.98 },
          html2canvas:  { scale: 2 },
          jsPDF:        { unit: 'cm', format: 'A4', orientation: orientation },
          pagebreak: { mode: 'avoid-all' }
        };
         
        html2pdf().set(opt).from(element).save();
    }
}