function getPercentCol(val, val_lt, shift = 0, multi = 1) {
    var col = "rgba(231, 231, 231, 0)";

    // Return invalid if one value = null

    if (val == null || val_lt == null) {
        return col;
    }

    // Values shift (e.g. Celsius -> Kelvin) and multi (e.g. Groundwater)

    val = val + shift
    val_lt = val_lt + shift

    val = val * multi
    val_lt = val_lt * multi

    // Get percentage if base != 0

    if (val_lt == 0) {
        return col;
    }

    var perc = Math.round(((val-val_lt) / Math.abs(val_lt)) * 100);

    // Return color

    if (perc < -150) { 
        return "rgba(69,117,180, 1)"; 
    } else if (perc < -100) { 
        return "rgba(116,173,209, 1)"; 
    } else if (perc < -50) { 
        return "rgba(171,217,233, 1)"; 
    } else if (perc < 0) { 
        return "rgba(224,243,248, 1)"; 
    } else if (perc == 0) { 
        return "rgba(255, 255, 255, 1)"; 
    } else if (perc < 50) { 
        return "rgba(254,224,144, 1)"; 
    } else if (perc < 100) {
        return "rgba(253,174,97, 1)"; 
    } else if (perc < 150) { 
        return "rgba(244,109,67, 1)"; 
    } else {
        return "rgba(215,48,39, 1)";
    }
}

function getPercentText(val, val_lt, shift = 0, multi = 1) {
    perc = ""

    // Return invalid if one value = null

    if (val == null || val_lt == null) {
        return perc;
    }

    // Values shift (e.g. Celsius -> Kelvin) and multi (e.g. Groundwater)

    val = val + shift
    val_lt = val_lt + shift

    val = val * multi
    val_lt = val_lt * multi

    // Get percentage if base != 0

    if (val_lt == 0) {
        return perc;
    }

    var perc = Math.round(((val-val_lt) / Math.abs(val_lt)) * 100);

    // Return with sign

    if (perc > 0) {
        return '+' + perc;
    } else {
        return perc;
    }
}

function getTextWatertemp(val, val_lt) {
    perc = ""

    // Return invalid if one value = null

    if (val == null || val_lt == null) {
        return perc;
    }

    var d = val - val_lt;
    d = Math.round(d*10)/10;

    // Return with sign

    if (d > 0) {
        return '+' + d;
    } else {
        return d;
    }
}

function getTextAirtemp(val, val_lt) {
    perc = ""

    // Return invalid if one value = null

    if (val == null || val_lt == null) {
        return perc;
    }

    var d = val - val_lt;
    d = Math.round(d*10)/10;

    // Return with sign

    if (d > 0) {
        return '+' + d;
    } else {
        return d;
    }
}

function getTextGw(val, val_lt_min, val_lt_mean, val_lt_max) {
    perc = ""

    // Return invalid if one value = null

    if (val == null || val_lt_min == null || val_lt_mean == null || val_lt_max == null) {
        return perc;
    }

    if (val < val_lt_mean) {
        var a = (val_lt_mean - val_lt_min); // = 1%
        var b = val_lt_mean - val; // Distance to mean (positive)
    } else if (val > val_lt_mean) {
        var a = (val_lt_max - val_lt_mean); // = 1%
        var b = val_lt_mean - val; // Distance to mean (negative)
    } else {
        return "+/-0";
    }

    if (a == 0) {
        return perc;
    }

    var d = Math.round(b/a*100);

    // Return with sign

    if (d > 0) {
        return '+' + d;
    } else {
        return d;
    }
}

function getPercentPointStyle(val, val_lt, shift = 0, multi = 1) {
    var col = "rgba(231, 231, 231, 1)";

    // Return invalid if one value = null

    if (val == null || val_lt == null) {
        return { 
            "opacity": 1,
            "radius": 4,
            "color": "#555", 
            "fillColor": "#fff", 
            "fillOpacity": 0.6, 
            "fillRule": "evenodd", 
            "lineCap": "round", 
            "lineJoin": "round", 
            "opacity": 1,
            "stroke": true,
            "weight": 1, 
        };
    }

    // Values shift (e.g. Celsius -> Kelvin) and multi (e.g. Groundwater)

    val = val + shift
    val_lt = val_lt + shift

    val = val * multi
    val_lt = val_lt * multi

    // Get percentage if base != 0

    if (val_lt == 0) {
        return col;
    }

    var perc = Math.round(((val-val_lt) / Math.abs(val_lt)) * 100);

    // Return color

    if (perc < -150) { 
        col = "rgba(69,117,180, 1)"; 
    } else if (perc < -100) { 
        col = "rgba(116,173,209, 1)"; 
    } else if (perc < -50) { 
        col = "rgba(171,217,233, 1)"; 
    } else if (perc < 0) { 
        col = "rgba(224,243,248, 1)"; 
    } else if (perc == 0) { 
        col = "rgba(255, 255, 255, 1)"; 
    } else if (perc < 50) { 
        col = "rgba(254,224,144, 1)"; 
    } else if (perc < 100) {
        col = "rgba(253,174,97, 1"; 
    } else if (perc < 150) { 
        col = "rgba(244,109,67, 1)"; 
    } else {
        col = "rgba(215,48,39, 1)";
    }

    return { 
        "bubblingMouseEvents": true, 
        "color": "#555", 
        "fill": true, 
        "fillColor": col, 
        "fillOpacity": 1, 
        "fillRule": "evenodd", 
        "lineCap": "round", 
        "lineJoin": "round", 
        "opacity": 1,
        "radius": 7,
        "stroke": true,
        "weight": 1, 
        "attribution": "Data: Hydrographie Kärnten",
    };
}

function getPointStyleWatertemp(val, val_lt, shift = 0) {
    var col = "rgba(231, 231, 231, 1)";

    // Return invalid if one value = null

    if (val == null || val_lt == null) {
        return { 
            "opacity": 1,
            "radius": 4,
            "color": "#555", 
            "fillColor": "#fff", 
            "fillOpacity": 0.6, 
            "fillRule": "evenodd", 
            "lineCap": "round", 
            "lineJoin": "round", 
            "opacity": 1,
            "stroke": true,
            "weight": 1, 
        };
    }

    // Values = Values + shift (e.g. temperature Celsius -> Kelvin) 

    var d = val - val_lt;

    // Return color

    if (d < -4.5) { 
        col = "rgba(69,117,180, 1)"; 
    } else if (d < -3) { 
        col = "rgba(116,173,209, 1)"; 
    } else if (d < -1.5) { 
        col = "rgba(171,217,233, 1)"; 
    } else if (d < 0) { 
        col = "rgba(224,243,248, 1)"; 
    } else if (d == 0) { 
        col = "rgba(255, 255, 255, 1)"; 
    } else if (d < 1.5) { 
        col = "rgba(254,224,144, 1)"; 
    } else if (d < 3) {
        col = "rgba(253,174,97, 1"; 
    } else if (d < 4.5) { 
        col = "rgba(244,109,67, 1)"; 
    } else {
        col = "rgba(215,48,39, 1)";
    }

    return { 
        "bubblingMouseEvents": true, 
        "color": "#555", 
        "fill": true, 
        "fillColor": col, 
        "fillOpacity": 1, 
        "fillRule": "evenodd", 
        "lineCap": "round", 
        "lineJoin": "round", 
        "opacity": 1,
        "radius": 7,
        "stroke": true,
        "weight": 1, 
        "attribution": "Data: Hydrographie Kärnten",
    };
}

function getPointStyleAirtemp(val, val_lt, shift = 0) {
    var col = "rgba(231, 231, 231, 1)";

    // Return invalid if one value = null

    if (val == null || val_lt == null) {
        return { 
            "opacity": 1,
            "radius": 4,
            "color": "#555", 
            "fillColor": "#fff", 
            "fillOpacity": 0.6, 
            "fillRule": "evenodd", 
            "lineCap": "round", 
            "lineJoin": "round", 
            "opacity": 1,
            "stroke": true,
            "weight": 1, 
        };
    }

    // Values = Values + shift (e.g. temperature Celsius -> Kelvin) 

    var d = val - val_lt;

    // Return color

    if (d < -6) { 
        col = "rgba(69,117,180, 1)"; 
    } else if (d < -4) { 
        col = "rgba(116,173,209, 1)"; 
    } else if (d < -2) { 
        col = "rgba(171,217,233, 1)"; 
    } else if (d < 0) { 
        col = "rgba(224,243,248, 1)"; 
    } else if (d == 0) { 
        col = "rgba(255, 255, 255, 1)"; 
    } else if (d < 2) { 
        col = "rgba(254,224,144, 1)"; 
    } else if (d < 4) {
        col = "rgba(253,174,97, 1"; 
    } else if (d < 6) { 
        col = "rgba(244,109,67, 1)"; 
    } else {
        col = "rgba(215,48,39, 1)";
    }

    return { 
        "bubblingMouseEvents": true, 
        "color": "#555", 
        "fill": true, 
        "fillColor": col, 
        "fillOpacity": 1, 
        "fillRule": "evenodd", 
        "lineCap": "round", 
        "lineJoin": "round", 
        "opacity": 1,
        "radius": 7,
        "stroke": true,
        "weight": 1, 
        "attribution": "Data: Hydrographie Kärnten",
    };
}

function getPointStyleGw(val, val_lt_min, val_lt_mean, val_lt_max) {
    var col = "rgba(231, 231, 231, 1)";

    // Return invalid if one value = null

    if (val == null || val_lt_min == null || val_lt_mean == null || val_lt_max == null) {
        return { 
            "opacity": 1,
            "radius": 4,
            "color": "#555", 
            "fillColor": "#fff", 
            "fillOpacity": 0.6, 
            "fillRule": "evenodd", 
            "lineCap": "round", 
            "lineJoin": "round", 
            "opacity": 1,
            "stroke": true,
            "weight": 1, 
        };
    }


    // Get percentage if base != 0

    if (val < val_lt_mean) {
        var a = (val_lt_mean - val_lt_min); // = 1%
        var b = val_lt_mean - val; // Distance to mean (positive)
    } else if (val > val_lt_mean) {
        var a = (val_lt_max - val_lt_mean); // = 1%
        var b = val_lt_mean - val; // Distance to mean (negative)
    }

    if (a == 0) {
        return col;
    }

    var perc = Math.round(b/a*100);

    // Return color

    if (perc < -150) { 
        col = "rgba(69,117,180, 1)"; 
    } else if (perc < -100) { 
        col = "rgba(116,173,209, 1)"; 
    } else if (perc < -50) { 
        col = "rgba(171,217,233, 1)"; 
    } else if (perc < 0) { 
        col = "rgba(224,243,248, 1)"; 
    } else if (perc == 0) { 
        col = "rgba(255, 255, 255, 1)"; 
    } else if (perc < 50) { 
        col = "rgba(254,224,144, 1)"; 
    } else if (perc < 100) {
        col = "rgba(253,174,97, 1"; 
    } else if (perc < 150) { 
        col = "rgba(244,109,67, 1)"; 
    } else {
        col = "rgba(215,48,39, 1)";
    }

    return { 
        "bubblingMouseEvents": true, 
        "color": "#555", 
        "fill": true, 
        "fillColor": col, 
        "fillOpacity": 1, 
        "fillRule": "evenodd", 
        "lineCap": "round", 
        "lineJoin": "round", 
        "opacity": 1,
        "radius": 7,
        "stroke": true,
        "weight": 1, 
        "attribution": "Data: Hydrographie Kärnten",
    };
}

// Is mobile?

function mobileCheck() {
  let check = false;
  (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
  return check;
};
