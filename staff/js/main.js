var superadmins = 0;
var heads = 0;
var admins = 0;
var mods = 0;
var trials = 0;

var toName = {
    "superadmin" : {name :"Super Admin", id : "super", rank : 1, amount:superadmins  },
    "headadmin" : {name :"Head Admin", id : "head", rank : 2, amount:heads },
    "admin" : {name :"Admin", id : "admin", rank : 3, amount:admins  },
    "moderator" : {name :"Moderator", id : "mod" , rank : 4, amount:mods },
    "trialmoderator": {name :"Trial Moderator", id : "trial", rank : 5, amount:trials },
}

function convertTimestamp(timestamp) {
    var d = new Date((timestamp-1209600) * 1000),	// Convert the passed timestamp to milliseconds
          yyyy = d.getFullYear(),
          mm = ('0' + (d.getMonth() + 1)).slice(-2),	// Months are zero based. Add leading 0.
          dd = ('0' + d.getDate()).slice(-2),			// Add leading 0.
          hh = d.getHours(),
          h = hh,
          min = ('0' + d.getMinutes()).slice(-2),		// Add leading 0.
          ampm = 'AM',
          time;
              
      if (hh > 12) {
          h = hh - 12;
          ampm = 'PM';
      } else if (hh === 12) {
          h = 12;
          ampm = 'PM';
      } else if (hh == 0) {
          h = 12;
      }

      if (yyyy < 2000){
          return "Never";
      }
      
      // ie: 2013-02-18, 8:35 AM	
      time = yyyy + '-' + mm + '-' + dd + ', ' + h + ':' + min + ' ' + ampm;
          
      if (time.indexOf("NaN") != -1){
          return "Never Logged On";
      }
      return time;
  }
var sorted = [];

function AddTableRow(data){
    var datatbl = JSON.parse(data);
    var adminTbl = JSON.parse(datatbl.admins);
    var time = JSON.parse(datatbl.time);

    var div = document.getElementById("insert");
    var tbl = document.getElementById("stafftable");

    var hitCount = 0;
    var itt = 0;

    while(hitCount < adminTbl.length-2){
        for(i = 0; i < time.length; i++){
            if (!("steamid" in adminTbl[itt])){
                console.log(adminTbl[itt]);
                itt++;
                continue;
            }
            if (time[i].steamid == adminTbl[itt].steamid){
                adminTbl[itt].time = time[i].datestarted;
                hitCount++;
                break;
            }
        }
        itt++;
    }

    var num = 1;
    var tblIndex = 0;

    while(num < 6){
        for(i=0;i<adminTbl.length;i++){
            if (toName[adminTbl[i].group] != undefined & num == toName[adminTbl[i].group].rank){
                sorted[tblIndex] = adminTbl[i];
                tblIndex++;
                toName[adminTbl[i].group].amount++;
            }
        }
        num++;
    }

    for(i=sorted.length;i>-1;i--){
        if (sorted[i] == null) {
            continue;
        }
        var newDiv = document.createElement("tr");
        var s =  [ 
            "<td class=\"pad\"> <a href=https://steamcommunity.com/profiles/"+ sorted[i].steam64 +"/>"+sorted[i].name+"</a> <p id=steamid>("+sorted[i].steamid+")</td>",
            "<td class=\"group\" id="+toName[sorted[i].group].id+">" + toName[sorted[i].group].name + "</td>",
            "<td class=\"centertext\">" + convertTimestamp(parseInt(sorted[i].time)) + "</td>"
        ].join("\n");
        newDiv.innerHTML = s; 
        div.insertAdjacentElement("afterend",newDiv);
    }

    var amounts = "";

    for(var k in toName){
        amounts = amounts + " " +toName[k].amount + " " + toName[k].name;
    }

    var divAmounts = document.createElement("p");
    var divAll = document.createElement("p");
    divAmounts.setAttribute("id","resultssmall");
    var html =  [ 
        amounts
    ].join("\n");
    divAmounts.innerHTML = html;
    tbl.insertAdjacentElement("afterend",divAmounts);

    divAll.setAttribute("id","results");
    html =  [ 
        "Showing " + sorted.length + " Staff Members"
    ].join("\n");
    divAll.innerHTML = html;
    tbl.insertAdjacentElement("afterend",divAll);
}