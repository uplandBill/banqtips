var wmrEventIsSaved=true;

var wmrwmr = "Hi Bill";

var pleft, ptop, xcor, ycor, gratTypesGbl;

function eventChanged() {
  wmrEventIsSaved = false;
}

function eventSaved() {
  wmrEventIsSaved = true;
}

function eventIsSaved() {
   if (wmrEventIsSaved == false)
      return true;
   else
      return false;
}

function get_xmlhttp() {
  if (window.XMLHttpRequest) {    // code for IE7+, Firefox, Chrome, Opera, Safari
    var xmlhttp=new XMLHttpRequest();
  } else {                        // code for IE6, IE5
    var xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  return xmlhttp;
}

function isEmpty(aVar){
  if (!aVar)
     return true;
  if (aVar =="")
     return true;
  if (aVar == "undefined")
     return true;
  return false;
}

function scroll_to_bottom() {
        var theScroll = document.getElementById('empGridBody');
        theScroll.scrollTop=theScroll.scrollHeight * 5;
//        var scrollTop = document.documentElement ? document.theScroll.scrollTop :
//                                           document.body.scrollTop;
}
//
//   Get Current Total employee hours.
//
function get_tot_hours() {
  var gridTotals = document.getElementById('empGridTots');
  return gridTotals.rows[0].cells[9].childNodes[0].value;
}

function emSize(pa){
	pa = pa || document.body;
	var who= document.createElement('div');
	var atts= {fontSize:'1em',padding:'0',position:'absolute',lineHeight:'1',visibility:'hidden'};
	for(var p in atts){
		who.style[p]= atts[p];
	}
	who.appendChild(document.createTextNode('M'));
	pa.appendChild(who);
	var fs= [who.offsetWidth,who.offsetHeight];
	pa.removeChild(who);
	return fs;
}

Function.prototype.p = function() {
	var args=Array.prototype.slice.call(arguments);
	var f=this;
	return function() {
		var inner_args=Array.prototype.slice.call(arguments);
		return f.apply(this, args.concat(inner_args));
	}
}

function object_keys(anObj) {
   if (Object.keys)
      return Object.keys(anObj);
   else {
      var result = [];
      for(var name in anObj) {
          if (anObj.hasOwnProperty(name))
            result.push(name);
      }
      return result;
   };
}

function reduce(combFunc, base, listArr) {
   forEach(listArr, function (listItem) {base = combFunc(base, listItem);});
   return base;
}

function add(a, b) {
   return a + b;
}

function sum(numbArr) {
   return reduce(add, 0, numbArr);
}

function getText(node) {

    if (node.nodeType === 3) {
        return node.data;
    }

    var txt = '';

    if (node = node.firstChild) do {
        txt += getText(node);
    } while (node = node.nextSibling);

    return txt;

}

function stop_prop(e) {
   e = e || window.event;
   if (e.target) var targ = e.target;
   else if (e.srcElement) var targ = e.srcElement;

   if (document.addEventListener) {
      e.preventDefault();
      e.stopPropagation();
    } else {
      e.cancelBubble = true;
      e.returnValue = false;
    }
}

function addEvent(obj, type, fn) {
  if (obj.addEventListener) {
      obj.addEventListener(type, fn, false);
      } else {
        obj['e' + type + fn] = fn;
        obj[type + fn] = function(){obj['e' + type + fn](window.event); }
        obj.attachEvent('on'+ type, obj[type + fn]);
      }
  }

function addEvent_delegate(obj, type, fn) {
  if (obj.addEventListener) {
      obj.addEventListener(type, fn, true);
      } else {
        obj['e' + type + fn] = fn;
        obj[type + fn] = function(){obj['e' + type + fn](window.event); }
        obj.attachEvent('on'+ type, obj[type + fn]);
      }
}

function removeEvent( obj, type, fn ) {
  if ( obj.detachEvent ) {
    obj.detachEvent( 'on'+type, obj[type+fn] );
    obj[type+fn] = null;
  } else
    obj.removeEventListener( type, fn, false );
}

function hasClass(ele,cls) {
  if (ele)
  return ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));
  else
  	return false;
}

function addClass(ele,cls) {
  if (ele && !hasClass(ele,cls)) ele.className += " "+cls;
}

function addClassEvent(e, cls) {
   e = e || window.event;
   if (e.target) var targ = e.target;
   else if (e.srcElement) var targ = e.srcElement;

   addClass(targ, cls);
}

function removeClass(ele,cls) {
  if (ele && hasClass(ele,cls)) {
      var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');
      ele.className=ele.className.replace(reg,' ');
  }
}

function trim1 (str) {
    return str.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
}

function trim2 (str) {
    return str.replace(/^\s+/, '').replace(/\s+$/, '');
}

function flipTrigger(ele) {
//  } else {
    if (hasClass(ele, "trigger")) {
       removeClass(ele, "trigger");
       addClass(ele, "triggers");
       if (eventIsSaved())
          popup("You forgot to save","OK", okButt);
    } else {
       removeClass(ele, "triggers");
       addClass(ele, "trigger");
     }
//  }
}

function main_off() {
   var mainMenu = document.getElementById('mainMenu');
   if (hasClass(mainMenu, "triggers")) {
       removeClass(mainMenu, "triggers");
       addClass(mainMenu, "trigger");
   }
}

function reports_off() {
   var repMenu = document.getElementById('reportsMenu');
   if (hasClass(repMenu, "triggers")) {
       removeClass(repMenu, "triggers");
       addClass(repMenu, "trigger");
   }
}

function config_off() {
   var repMenu = document.getElementById('configMenu');
   if (hasClass(repMenu, "triggers")) {
       removeClass(repMenu, "triggers");
       addClass(repMenu, "trigger");
   }
}

function menus_off() {
   main_off();
   reports_off();
   config_off();
}

function removeElm(elm, child) {
	if (document.getElementById(child))
	   document.getElementById(elm).removeChild(document.getElementById(child));
}

function removeKids(elm) {
  var childrenCnt = elm.childNodes.length;
  if (childrenCnt > 0) {
      while (elm.hasChildNodes()){
	        elm.removeChild(elm.firstChild);
      }
  }
}

function coordinates(e) {
if (e == null) { e = window.event;}
var sender = (typeof( window.event ) != "undefined" ) ? e.srcElement : e.target;

if (sender.id=="listbox_div")  {
     mouseover=true;
     pleft=parseInt(window.getComputedStyle(sender, "").getPropertyValue("left"));
     ptop=parseInt(window.getComputedStyle(sender, "").getPropertyValue("top"));
//     ptop=parseInt(sender.style.top);
     xcoor=e.clientX;
     ycoor=e.clientY;
  //   alert("click:" +pleft +"-"+ ptop +"-"+ xcoor + "-" + ycoor);

    addEvent(sender, "mousemove", moveImage);
    addEvent(sender, "mouseout", mouseup);
     return false;
  }
}

function moveImage(e) {
   if (e == null) { e = window.event;}
   var sender = (typeof( window.event ) != "undefined" ) ? e.srcElement : e.target;

   sender.style.left=pleft+e.clientX-xcoor+"px";
   sender.style.top=ptop+e.clientY-ycoor+"px";
   return false;
}

function mouseup(e) {
   e = e || window.event;
   if (e.target) var targ = e.target;
   else if (e.srcElement) var targ = e.srcElement;

//   var sender = (typeof( window.event ) != "undefined" ) ? e.srcElement : e.target;

//   removeEvent(sender, "mousemove", moveImage);
   removeEvent(targ, "mousemove", moveImage);
}

function set_image(unitId) {
   jsonAjax("jsonGetUnitData", function(json) {var jsonUnit = eval('(' +json+ ')'); alert("Image is: " + jsonUnit[unitId]["unitImg"]);}, unitId);
}

function listConfigs(str) {
  if (str=="")  {
    document.getElementById("todoform").innerHTML="No Configs";
    return;
    }
  var xmlhttp = get_xmlhttp();
  xmlhttp.onreadystatechange=function()  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200)    {
      document.getElementById("todoform").innerHTML=xmlhttp.responseText;
     }
   }
  xmlhttp.open("GET","getConfigs.php?user="+str,true);
  xmlhttp.send();
  }

function getRec(func, parms, destElm) {
  if (func=="")  {
    document.getElementById(destElm).innerHTML="no form";
    return;
  }
  var xmlhttp = get_xmlhttp();
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById(destElm).innerHTML=xmlhttp.responseText;
      f_tcalInit();
      if (func == 'formEmps') {
         addEeEvents();
         get2("empHist", parms, "formEmpHist");
//       updEeTypeInfo();
//       updDeptInfo();
      }
    }
  }
  xmlhttp.open("GET",func+".php?" +parms,true);
  xmlhttp.send();
}

function doform(e) {
   e = e || window.event;
   if (e.target) var targ = e.target;
   else if (e.srcElement) var targ = e.srcElement;

   var json = eval('(' +targ.getAttribute("json")+ ')');
   var formToLoad = json["func"];
   var func2 = json["func2"];
//   alert("doForm: " + json["func"] + " and also: " + func2);

   xmlhttpPost4(formToLoad, json, 'todoform', window[func2]);
}

function buildEd(tabName, funcName) {
  if (tabName=="") {
    document.getElementById("todoform").innerHTML="no form";
    return;
  }
  var xmlhttp = get_xmlhttp();
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("todoform").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","buildEd.php?table="+tabName+"&funcName="+funcName,true);
  xmlhttp.send();
}

function get1(tabName, whereClause) {
  if (whereClause=="")  {
    document.getElementById("todoform").innerHTML="no form";
    return;
  }
  var xmlhttp = get_xmlhttp();
  xmlhttp.onreadystatechange=function()  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("todoform").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","get1.php?table="+tabName+"&where="+whereClause,true);
  xmlhttp.send();
}

function get2(func, getParms, destElm, doFunc) {
  if (func=="") {
    document.getElementById(destElm).innerHTML="no function name";
    return;
  }
  var xmlhttp = get_xmlhttp();
  xmlhttp.onreadystatechange=function()  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200)    {
      document.getElementById(destElm).innerHTML=xmlhttp.responseText;
      if (doFunc)
        doFunc();
    }
  }
  xmlhttp.open("GET",func+".php"+"?"+getParms,true);
  xmlhttp.send();
}

function set_zero(e) {
   e = e || window.event;
   if (e.target) var targ = e.target;
   else if (e.srcElement) var targ = e.srcElement;

   targ.value = trim2(targ.value);
   if (targ.value == "")
      targ.value = 0;
}

function updDeptInfo(e) {
   e = e || window.event;
   if (e.target) var targ = e.target;
   else if (e.srcElement) var targ = e.srcElement;

   var deptId = document.getElementById('deptId').value;
   var unitId = document.getElementById('unitId').value;
   get2("getDeptInfo","unitId="+unitId+"&deptId="+deptId,"deptInfo", deptEditEvent);
}

function updEeTypeInfo(e) {
   e = e || window.event;
   if (e.target) var targ = e.target;
   else if (e.srcElement) var targ = e.srcElement;

   var eeType = document.getElementById('eeType').value;
   var unitId = document.getElementById('unitId').value;
   get2("getEeTypeInfo","unitId="+unitId+"&eeType="+eeType,"eeTypeInfo");
}

function addEeEvents() {
   addEvent(document.getElementById('deptId'), 'change', updDeptInfo);
   addEvent(document.getElementById('eeType'), 'change', updEeTypeInfo);
}

function blur_event(e) {
   e = e || window.event;
   if (e.target) var targ = e.target;
   else if (e.srcElement) var targ = e.srcElement;

   var elemId = targ.getAttribute("id");
//   var eventNum = targ.getAttribute("eventnum");
   if (targ.tagName == "INPUT") {
      if (targ.value != targ.defaultValue)
         eventChanged(); // alert(elemId + " has changed");
    }
   else
      if (targ.tagName == "SELECT") {
         if (!targ.options[targ.selectedIndex].defaultSelected)
             eventChanged();  // alert(elemId + " has changed");
         }
      else
         alert("Blur on " + elemId + " : " + targ.tagName);
}

function add_blurs() {
//   document.getElementById('enterFunc').onfocusin = blur_event;
   document.getElementById('enterFunc').onfocusout = blur_event;
//   document.getElementById('enterFunc').addEventListener('focus',blur_event,true);
   addEvent_delegate(document.getElementById('enterFunc'), 'blur', blur_event);
//      document.getElementById('enterFunc').addEventListener('blur',blur_event,true);
}

// Based on the employee type in Cell 3, get the set of grat types from the grats obj, then chose the one that matches the given grat and update the corresponding grid cell.
// gratNum: 1-3 corresponds to grat row number in grats grid
// 
function set_grat_cell(gratNum, gratId, gratVal) {
  return function(row) {
     var empObj={};
     var gridCell = row.cells[gratNum+3];
     if (gratVal != "X") {
        empObj["eeType"] = row.cells[3].childNodes[0].value;
        get_grat_dets(empObj, gratVal, gratId);
        if (empObj[gratId]) {
           gridCell.innerHTML=empObj[gratId]["gratDescr"];
           gridCell.setAttribute("gratType",empObj[gratId]["gratType"]);
           gridCell.setAttribute("group",empObj[gratId]["groupType"]);
           gridCell.setAttribute("cutRate",empObj[gratId]["cutRate"]);
           gridCell.setAttribute("title","");
           removeClass(gridCell, "hideCell");
           if (empObj[gratId]["netAcct"] == "Y") {
              addClass(gridCell,"netAcct");
              gridCell.setAttribute("title","This is a net account.");
           } else {
              removeClass(gridCell,"netAcct");
              gridCell.setAttribute("title","");
           }
        } else {
          gridCell.setAttribute("group","");
          gridCell.setAttribute("cutRate","0");
          removeClass(gridCell, "netAcct");
          gridCell.setAttribute("title","not found");
        }
     } else {
       gridCell.innerHTML="";
       gridCell.setAttribute("group","");
       gridCell.setAttribute("cutRate","0");
       removeClass(gridCell, "netAcct");
       gridCell.setAttribute("title","");
     }
  }
}

function show_col(colNum) {
  return function(row) {
        removeClass(row.cells[colNum], "hidecell");
  }
}

function hide_col(colNum) {
  return function(row) {
        addClass(row.cells[colNum], "hidecell");
  }
}

function gratChange(e) {
   e = e || window.event;
   if (e.target) var targ = e.target;
   else if (e.srcElement) var targ = e.srcElement;

   var gratRow = targ.parentNode.parentNode.rowIndex + 1;
//   var gratNum = "grat" + gratRow;
//   alert("change at: " + gratNum + " " + targ.id);   //same thing

   loopGrid(set_grat_cell(gratRow, targ.id, targ.value));
   updateEmpCnts();
   var gridHeads = document.getElementById("empGridHead");
   var gridTots  = document.getElementById("empGridTots");
   if (targ.id == "grat1")
      if (targ.value == "X") {
         loopGrid(hide_col(14));
         loopGrid(hide_col(4));
         addClass(gridHeads.rows[0].cells[14], "hidecell");
         addClass(gridTots.rows[0].cells[13], "hidecell");
         addClass(gridHeads.rows[0].cells[4], "hidecell");
      } else {
         loopGrid(show_col(14));
         loopGrid(show_col(4));
         removeClass(gridHeads.rows[0].cells[14], "hidecell");
         removeClass(gridTots.rows[0].cells[13], "hidecell");
         removeClass(gridHeads.rows[0].cells[4], "hidecell");
         gridHeads.rows[0].cells[14].innerHTML = getOption(targ, targ.value, "gtd");
      }
   if (targ.id == "grat2")
      if (targ.value == "X") {
         loopGrid(hide_col(15));
         loopGrid(hide_col(5));
         addClass(gridHeads.rows[0].cells[15], "hidecell");
         addClass(gridTots.rows[0].cells[14], "hidecell");
         addClass(gridHeads.rows[0].cells[5], "hidecell");
      } else {
         loopGrid(show_col(15));
         loopGrid(show_col(5));
         removeClass(gridHeads.rows[0].cells[15], "hidecell");
         removeClass(gridTots.rows[0].cells[14], "hidecell");
         removeClass(gridHeads.rows[0].cells[5], "hidecell");
         gridHeads.rows[0].cells[15].innerHTML = getOption(targ, targ.value, "gtd");
      }
   if (targ.id == "grat3")
      if (targ.value == "X") {
         loopGrid(hide_col(16));
         loopGrid(hide_col(6));
         addClass(gridHeads.rows[0].cells[16], "hidecell");
         addClass(gridTots.rows[0].cells[15], "hidecell");
         addClass(gridHeads.rows[0].cells[6], "hidecell");
      } else {
         loopGrid(show_col(16));
         loopGrid(show_col(6));
         removeClass(gridHeads.rows[0].cells[16], "hidecell");
         removeClass(gridTots.rows[0].cells[15], "hidecell");
         removeClass(gridHeads.rows[0].cells[6], "hidecell");
         gridHeads.rows[0].cells[16].innerHTML = getOption(targ, targ.value, "gtd");
      }
   calcGrid();
}

function reset_cut_rates(gratRow) {
   var gratNum  = gratRow.rowIndex + 1;
   var gratType = gratRow.cells[0].childNodes[0].value;
   var gratId = gratRow.cells[0].childNodes[0].id;
//   alert('Loop grid ' +gratNum + ' ' + gratType + ' ' + gratId)
   loopGrid(set_grat_cell(gratNum, gratId, gratType));
   updateEmpCnts();
}

function loop_grats(func) {
   var gratsGrid = document.getElementById("gratsGrid");
   var gratCnt=0, row;
   var gratsLen = gratsGrid.rows.length;
   for (var i = 0; i < gratsLen; i++) {
      row = gratsGrid.rows[i];
      func(row);
   }
}

function rateDateChange(e) {
   e = e || window.event;
   if (e.target) var targ = e.target;
   else if (e.srcElement) var targ = e.srcElement;

   var effdt = targ.value;
   var unitId = document.getElementById('unitId').innerHTML.split(" ")[1];;
   var jsonText = '{"unitId":"' +unitId+ '","effdt":"' +effdt+ '"}';
   var json = eval('(' +jsonText+ ')');
   xmlhttpPost4('jsonGetGratTypes.php', json, 'gratTypes', function() {loop_grats(reset_cut_rates); calcGrid(); });
//   loop_grats(reset_cut_rates);
//   calcGrid();
}

function addFuncEvents() {
//   var theBody=document.getElementsByTagName('body');
//   addEvent(theBody, 'blur', function(){alert("hi");});
//   window.onblur = function(){alert("window blur");};
   add_blurs();
   addEvent(document.getElementById('funcDate'), 'change', funcDateChange);
   addEvent(document.getElementById('funcType'), 'change', funcChange);
   addEvent(document.getElementById('totCovers'), 'blur', calcGrid);
   addEvent(document.getElementById('grat1Grat'), 'blur', calcGrid);
   addEvent(document.getElementById('grat2Grat'), 'blur', calcGrid);
   addEvent(document.getElementById('grat3Grat'), 'blur', calcGrid);
   addEvent(document.getElementById('defSetup'), 'blur', calcGrid);
   addEvent(document.getElementById('defClear'), 'blur', calcGrid);
   addEvent(document.getElementById('defExtra'), 'blur', calcGrid);
   addEvent(document.getElementById('funcNumWk'), 'change', funcNumChange);

   addEvent(document.getElementById('grat1'), 'change', gratChange);
   addEvent(document.getElementById('grat2'), 'change', gratChange);  //wmrwmr
   addEvent(document.getElementById('grat3'), 'change', gratChange);

   addEvent(document.getElementById('rateDate'), 'change', rateDateChange);  //New event  for Rate Date field
}

function weekFunc1(unitId, funcName, addlParm, addclass, doFunc) {
if (unitId=="") {
  document.getElementById("todoform").innerHTML="no unit Id";
  return;
  }
  var xmlhttp = get_xmlhttp();
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      removeClass(document.getElementById("todoform"),"listarea");
      removeClass(document.getElementById("todoform"),"formarea");

      if (addclass)
        addClass(document.getElementById("todoform"),addclass);
      document.getElementById("todoform").innerHTML=xmlhttp.responseText;
      f_tcalInit();
      eventSaved();
      if (funcName == 'enterFunc') {
        var listParms={"destDiv":"rightcol","listId":"empListing", "listTab":"empList", "alphaId":"empAlphas", "buttId":"empListButts"};
        popright("getEes",unitId+"&extra=y", "rightcol", function(){set_events2(listParms); loopGrid(eeGridSel); if (document.getElementById("eventNum").innerHTML == "new") add_eeTypes1();});
//       var listParms={"listId":"empListing", "listTab":"empList", "alphaId":"empAlphas", "buttId":"empListButts"};
//       pop_ee_list2("rightCol", listParms, function(){set_events2(); loopGrid(eeGridSel); if (document.getElementById("eventNum").innerHTML == "new") add_eeTypes1();});
        addFuncEvents();
      } else {
       if (funcName == 'repWeekCsv' || funcName == 'repWeekEe' || funcName == 'repWeekAudit' || funcName == 'repWeekFuncs' || funcName == 'auditWeek' || funcName == 'startWeek' || funcName == 'closeWeek') {
      } else {
         var t = new SortableTable(document.getElementById('empsList'), 100);
      }
     }
    if (doFunc)
       doFunc(unitId, funcName);
    }
  }
  xmlhttp.open("GET",funcName+".php?unitId="+unitId+"&func=start"+addlParm,true);
  xmlhttp.send();
}

function call_report(unitId, funcName, option, addclass, doFunc) {
if (unitId=="") {
  document.getElementById("todoform").innerHTML="no unit Id";
  return;
  }
  var xmlhttp = get_xmlhttp();
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      removeClass(document.getElementById("todoform"),"listarea");
      removeClass(document.getElementById("todoform"),"formarea");

      if (addclass)
        addClass(document.getElementById("todoform"),addclass);
      document.getElementById("todoform").innerHTML=xmlhttp.responseText;
      f_tcalInit();
      eventSaved();
    if (doFunc)
       doFunc(unitId, option);
    }
  }
  xmlhttp.open("GET",funcName+"?unitId="+unitId+"&option="+option,true);
  xmlhttp.send();
}

function set_result(jsonResult) {
  var json =  eval('(' +jsonResult+ ')');
  document.getElementById('weekResult').innerHTML = "" + json["result"];
  if (json["result"] == "Success") {
  	  document.getElementById('currWeekStat').innerHTML = "Status: The week has been closed.  There is no open week.";
  	  document.getElementById('wkendClose').setAttribute("disabled","disabled");
  } else {
  	  document.getElementById('currWeekStat').innerHTML = "Status: Week was not closed.  " + json["msg"];
  }
}

function set_result2(jsonResult) {
   var json =  eval('(' +jsonResult+ ')');
//   document.getElementById('weekResult').innerHTML = "" + json["result"];
   if (json["result"] == "Success") {
  	  document.getElementById('currWeekStat').innerHTML =  "" + json["msg"];
   } else {
   	  document.getElementById('currWeekStat').innerHTML =  "Result: " + json["result"] +" "+ json["msg"];
   }
}

function wkendClose() {
	 var unitId = document.getElementById("unitId").innerHTML;
	 var f='jsonCloseWeek.php?unitId=' +unitId;
	 jsonAjax('jsonCloseWeek', set_result, unitId, '')
}

function wkendOpen() {
   var wk=document.getElementById('openCloseDate').value;
	 var unitId = document.getElementById("unitId").innerHTML +"&wkendDt=" +wk;
    
	 jsonAjax('jsonOpenWeek', set_result2, unitId, '')
}

function set_wkend_list(json) {
	document.getElementById("weekEndList").innerHTML = json;
}

function wkendDtChg() {
   var wk=document.getElementById('openCloseDate').value;
}

function weekEndStatus(unitId) {
   var wkendCloseEl = document.getElementById("wkendClose");
   addEvent(wkendCloseEl,'click', wkendClose);
   var wkendOpenEl  = document.getElementById("wkendOpen");
   addEvent(wkendOpenEl, 'click', wkendOpen);
   f_tcalInit();
}
//
//   This is called when the hours field is changed for an employee
//
function hours_changed(e) {
  e = e || window.event;
  if (e.target) var targ = e.target;
  else if (e.srcElement) var targ = e.srcElement;

// alert("hours changed event");

  set_zero();
  loopGrid(comp_total_hours);
  calcGrid();
}

function fillArea(unitId, funcName, addlParm, addclass, doFunc) {
  if (unitId=="") {
     document.getElementById("todoform").innerHTML="no unit Id";
     return;
  }
  var xmlhttp = get_xmlhttp();
  xmlhttp.onreadystatechange=function() {
     if (xmlhttp.readyState==4 && xmlhttp.status==200) {
        removeClass(document.getElementById("todoform"),"listarea");
        removeClass(document.getElementById("todoform"),"formarea");

        if (addclass)
           addClass(document.getElementById("todoform"),addclass);
        document.getElementById("todoform").innerHTML=xmlhttp.responseText;
        if (doFunc)
           doFunc(unitId, funcName);
     }
  }
  xmlhttp.open("GET",funcName+".php?unitId="+unitId+"&func=start"+addlParm,true);
  xmlhttp.send();
}

// {"listId":"empListing", "alphaId":"empAlphas", "buttId":"empListButts'}

//
//  Retrieve list of employees with Ajax call, and stores the results (which will be JSON)
//  as a child of the provided id field.  Generally this is hidden on the page.
//
function hide_ee_list(funcName, unitId, resId, doFunc) {
  if (unitId=="")  {
    document.getElementById(resId).innerHTML="";
    return;
  }
  var xmlhttp = get_xmlhttp();
  xmlhttp.onreadystatechange=function()  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200)    {
//     var eeListObj = eval('(' +xmlhttp.responseText+ ')');
      var eeMaster = document.createElement("div");
      eeMaster.setAttribute("id", "eeMaster");
      eeMaster.innerHTML = xmlhttp.responseText;
      document.getElementById(resId).appendChild(eeMaster);

      if (doFunc)
         doFunc();
    }
  }
  xmlhttp.open("GET",funcName+".php?unitId="+unitId,true);
  xmlhttp.send();
}
//
//  Bring in a new function to the page.  AJAX (below) initiates, this function does follow-ups
//
function pop_rest_form() {
  var listParms={"destDiv":"rightcol","listId":"empListing", "listTab":"empList", "alphaId":"empAlphas", "buttId":"empListButts"};
//  alert("load rest " + listParms["destDiv"]);
  pop_ee_list2(listParms); 
  set_events2(listParms); 
  if (document.getElementById("eventNum").innerHTML == "new") //If still 'new' then it has not been saved
     add_eeTypes1(); 
  loopGrid(eeGridSel); 
  addFuncEvents();
}

// Handles the loading of a new form/new event
function func_form(unitId, funcName, addlParm) {
  if (unitId=="") {
    document.getElementById("todoform").innerHTML="no unit Id";
    return;
  }
  var xmlhttp = get_xmlhttp();
  xmlhttp.onreadystatechange=function() {
     if (xmlhttp.readyState==4 && xmlhttp.status==200) {
       removeClass(document.getElementById("todoform"),"listarea");
       removeClass(document.getElementById("todoform"),"formarea");
       document.getElementById("todoform").innerHTML=xmlhttp.responseText;
       if (document.getElementById("funcDate")) {
         f_tcalInit();
//         var listParms={"destDiv":"rightcol", "listId":"empListing", "listTab":"empList", "alphaId":"empAlphas", "buttId":"empListButts"};
//         hide_ee_list('jsonGetEes', unitId, 'hiddenData2', function() {pop_ee_list2(listParms, set_events2); if (document.getElementById("eventNum").innerHTML == "new") add_eeTypes1(); loopGrid(eeGridSel); addFuncEvents();});
         hide_ee_list('jsonGetEes', unitId, 'hiddenData2', pop_rest_form);
       }
     }
   }
   xmlhttp.open("GET",funcName+".php?unitId="+unitId+"&func=start"+addlParm,true);
   xmlhttp.send();
}
//
//  Populate the EE Grid from a saved function
//
function loadEeGrid(eventNum, unitId) {
  var json, newrow, newcell, emplid, empData;
  var xmlhttp = get_xmlhttp();
  xmlhttp.onreadystatechange=function() {
  if (xmlhttp.readyState==4 && xmlhttp.status==200) {
     var empGrid = document.getElementById("empGridTab");
     var thisRowNum, nextRow = empGrid.rows.length;
     var empList = eval('(' +xmlhttp.responseText+ ')');
     for (var empVal in empList) {
     	  json = empList[empVal];
         get_grat_types(json);
         addToGrid(json);
      }
//      var listParms={"destDiv":"rightcol", "listId":"empListing", "listTab":"empList", "alphaId":"empAlphas", "buttId":"empListButts"};
//      hide_ee_list('jsonGetEes', unitId, 'hiddenData2', function() {pop_ee_list2(listParms, set_events2); loopGrid(eeGridSel); if (document.getElementById("eventNum").innerHTML == "new") add_eeTypes1(); addFuncEvents();});
//    var listParms={"listId":"empListing", "listTab":"empList", "alphaId":"empAlphas", "buttId":"empListButts"};
//    hide_ee_list('jsonGetEes', unitId, 'hiddenData2', function() {pop_ee_list2("rightcol", listParms); loopGrid(eeGridSel); set_events2(); if (document.getElementById("eventNum").innerHTML == "new") add_eeTypes1(); addFuncEvents();});
//      popright("getEes",unitId+"&extra=y", "rightcol", function(){set_events2(); loopGrid(eeGridSel);});
      hide_ee_list('jsonGetEes', unitId, 'hiddenData2', pop_rest_form);

      comp_total_hours();
      calcGrid();
      }
   }
   xmlhttp.open("GET","jsonFuncEmps.php?eventNum="+eventNum+"&unitId="+unitId,true);
   xmlhttp.send();
}

function loadFunc2(unitId, eventNum) {
//    alert("Go get " + unitId + " eve " + eventNum);
  if (eventNum=="") {
    document.getElementById("todoform").innerHTML="no event number";
    return;
  }
  var xmlhttp = get_xmlhttp();
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("todoform").innerHTML=xmlhttp.responseText;
      f_tcalInit();
//    popright("getEes",unitId, "rightcol", set_events2);
      removeKids(document.getElementById("rightcol"));     //Clear out the ee list ... in future can we keep the list and not re-load it?  for next prev buttons
      loadEeGrid(eventNum, unitId);
      addFuncEvents();
      eventSaved();
    }
  }
  xmlhttp.open("GET","enterFunc.php?unitId="+unitId+"&func=start&eventNum="+eventNum,true);
  xmlhttp.send();
}

function loadFunc(e) {
   e = e || window.event;
   if (e.target) var targ = e.target;
   else if (e.srcElement) var targ = e.srcElement;

   var unitId = targ.getAttribute("unitid");
   var eventNum = targ.getAttribute("eventnum");
   loadFunc2(unitId, eventNum);
   //    	alert(emSize());

}

function saveKey1xxxxxxxx(str) {
  if (str=="") {
    document.getElementById("todoform").innerHTML="";
  return;
  }
  var xmlhttp = get_xmlhttp();
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("statusResult").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","todosave.php?todo="+str,true);
  xmlhttp.send();
}

function clearRight() {
   document.getElementById("rightcol").innerHTML="";
}

function hide_right() {
   addClass(document.getElementById("rightcol"),"hidden");
}

function show_right() {
   removeClass(document.getElementById("rightcol"),"hidden");
}

function clearForm() {
   var formDiv=document.getElementById("todoform");
   removeKids(formDiv);
}

function main_reg() {
   removeClass(document.getElementById("todoform"),"mainformW2");
   addClass(document.getElementById("todoform"),"mainformW1");
}

function main_wide() {
   removeClass(document.getElementById("todoform"),"mainformW1");
   addClass(document.getElementById("todoform"),"mainformW2");
}

function popright(funcName, unitIdand, resId, eventFunc) {
  if (unitIdand=="")  {
    document.getElementById(resId).innerHTML="";
    return;
  }
  var xmlhttp = get_xmlhttp();
  xmlhttp.onreadystatechange=function()  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200)    {
      document.getElementById(resId).innerHTML=xmlhttp.responseText;
      if (eventFunc)
         eventFunc();
//      loopGrid(eeGridSel);
    }
  }
  xmlhttp.open("GET",funcName+".php?unitId="+unitIdand,true);
  xmlhttp.send();
}

//Executed upon event for when clicking on an employee type button at top of employee list in right column
function extract_list(objParms) {
  var eeListObj = eval('(' +document.getElementById("eeMaster").innerHTML+ ')');

  var destDivId = objParms["destDiv"];
  var destDiv = document.getElementById(destDivId);

  var empListDivId = destDivId + "_empList";
  var empListTblId = destDivId + "_empTab";
  var empAlphasId  = destDivId + "_empAlphas";


  var eeType = objParms["eeType"];

  if (eeType != "A") { 
     for (emplid in eeListObj["empList"]) {
  	    if (eeListObj["empList"][emplid]["type"] != eeType) {
  	 	      delete eeListObj["empList"][emplid];
  	    }
  	 }
  }

  var resId = objParms["destDiv"];

  //load the employee list into the right column
//  var listParms={"listId":"empListing", "listTab":"empList", "alphaId":"empAlphas", "buttId":"empListButts"};
  load_ee_list2(eeListObj, objParms);

  //delete lettters
  removeKids(document.getElementById(empAlphasId));
  document.getElementById(resId).removeChild(document.getElementById(empAlphasId));
  load_ee_letters(eeListObj, resId, objParms);

  if (destDivId == "rightcol")
     //set events in employee list
     set_events2(objParms);
  else
     empList_Events(objParms);
  //highlight selected employees
  loopGrid(eeGridSel);
}

function pop_ee_list2(objParms, eventFunc) {
  var eeListObj = eval('(' +document.getElementById("eeMaster").innerHTML+ ')');
  var destDiv = objParms["destDiv"];

  if (objParms["listId"])
      load_ee_list2(eeListObj, objParms);
      
  if (objParms["alphaId"])
      load_ee_letters(eeListObj, destDiv, objParms);
      
  if (objParms["buttId"])
     load_ee_buttons(eeListObj, destDiv, objParms);

  if (eventFunc)
     eventFunc(objParms);
}

function pop_ee_list(funcName, unitId, resId, objParms, eventFunc) {
  if (unitId=="")  {
    document.getElementById(resId).innerHTML="";
    return;
  }
  var xmlhttp = get_xmlhttp();
  xmlhttp.onreadystatechange=function()  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200)    {
       var eeListObj = eval('(' +xmlhttp.responseText+ ')');
       if (objParms["listId"])
          load_ee_list(eeListObj, resId, objParms);
       if (objParms["alphaId"])
          load_ee_letters(eeListObj, resId, objParms);
       if (objParms["buttId"])
          load_ee_buttons(eeListObj, resId, objParms);
       set_events2(objParms);

      if (eventFunc)
         eventFunc(objParms);
//    loopGrid(eeGridSel);
    }
  }
  xmlhttp.open("GET",funcName+".php?unitId="+unitId,true);
  xmlhttp.send();
}

function qs_partition(array, begin, end, pivot) {
	var piv=array[pivot], tmp;
//	array.swap(pivot, end-1);
	tmp=array[pivot];
	array[pivot]=array[end-1];
	array[end-1]=tmp;
	
	var store=begin;
	var ix;
	for(ix=begin; ix<end-1; ++ix) {
		if(array[ix]<=piv) {
//			array.swap(store, ix);
	    tmp=array[store];
	    array[store]=array[ix];
    	array[ix]=tmp;
			++store;
		}
	}
//	array.swap(end-1, store);
	    tmp=array[end-1];
	    array[end-1]=array[store];
    	array[store]=tmp;
	return store;
}

function qsort(array, begin, end) {
	if(end-1>begin) {
		var pivot=begin+Math.floor(Math.random()*(end-begin));

		pivot=qs_partition(array, begin, end, pivot);

		qsort(array, begin, pivot);
		qsort(array, pivot+1, end);
	}
}

function quick_sort(array) {
	qsort(array, 0, array.length);
}

function sort_emps(eeListObj) {
  var sortArr=new Array();
  var arrCnt=0;
  for (emplid in eeListObj["empList"]) {
//  	alert(eeListObj["empList"][emplid]["name"] +":"+ eeListObj["empList"][emplid]["name"].substring(2,3));
        sortArr[arrCnt]=eeListObj["empList"][emplid]["name"].substring(0,1) + eeListObj["empList"][emplid]["type"] + eeListObj["empList"][emplid]["name"] +"|"+ emplid;
        arrCnt++;
  }
  quick_sort(sortArr);
  return sortArr;
}

//  var listParms={"destDiv":"eePopDiv", listId":"empListing", "listTab":"empList", "alphaId":"empAlphas", "buttId":"empListButts"};
//  Load a lits of employees from an ee list object, into the destination id, per the object parmeters
function load_ee_list2(eeListObj, objParms) {
   var destDivId = objParms["destDiv"];
   var destDiv = document.getElementById(destDivId);

   var empListDivId = destDivId + "_empList";
   var empListTblId = destDivId + "_empTab";

   var listDiv = document.createElement("div");
   listDiv.setAttribute("id", empListDivId); //objParms["listId"]);  //id of the actual emp list
   addClass(listDiv,"empListing");

   removeElm(destDivId, empListDivId);   //objParms["listId"]);
//   removeKids(document.getElementById(destId));

   var listTab=document.createElement("table");
   listTab.setAttribute("id", empListTblId); //objParms["listTab"]); //id of the table element
   addClass(listTab,"empList");
   var emplid, empRow, empCell, rowClass=1, rowNum=0;
   
   var sortedArr = sort_emps(eeListObj);
   var lettCnt=0, firstLett, prevLett = "A";
   delete eeListObj["letters"];
   eeListObj["letters"]={};

   for (var i=0; sortedArr[i]; i++) {
      emplid = sortedArr[i].split("|")[1];
      
//   for (emplid in eeListObj["empList"]) {
   	
      empRow =listTab.insertRow(rowNum);
      empCell=empRow.insertCell(0);
      if (destDivId == "rightcol")
         empCell.setAttribute("id",emplid);  //id of the employee cell
      else
         empCell.setAttribute("id", "e_" + emplid);  //id of the employee cell
      empCell.setAttribute("empid",emplid);
//      chargeCatTots[i] 
      empCell.innerHTML = eeListObj["empList"][emplid]["name"]+": "+eeListObj["empList"][emplid]["role"];
      addClass(empCell,"row"+rowClass);
      addClass(empCell,"multiVal");
      empCell.setAttribute("name",eeListObj["empList"][emplid]["type"]+":"+eeListObj["empList"][emplid]["payGrp"]+":"+eeListObj["empList"][emplid]["class"]);
      if (destDivId == "rightcol")
         addEvent(empCell, "click", selectee);

      firstLett = eeListObj["empList"][emplid]["name"].substring(0,1);
      if (firstLett != prevLett) {
//      	alert(firstLett + " "  + lettCnt);
      	prevLett = firstLett;
      	eeListObj["letters"][prevLett]=lettCnt;
      }
      lettCnt++;

      rowClass=3 - rowClass;
      rowNum++;
   }
   
   listDiv.appendChild(listTab);
   
   destDiv.appendChild(listDiv);
}

function load_ee_list(eeListObj, destId, objParms) {
   var listDiv = document.createElement("div");
   listDiv.setAttribute("id", objParms["listId"]);
   addClass(listDiv,"empListing");
   var listTab=document.createElement("table");
   listTab.setAttribute("id",objParms["listTab"]);
   addClass(listTab,"empList");
   var emplid, empRow, empCell, rowClass=1, rowNum=0;
   
   for (emplid in eeListObj["empList"]) {
      empRow =listTab.insertRow(rowNum);
      empCell=empRow.insertCell(0);
      empCell.setAttribute("id",emplid);
      empCell.setAttribute("empid",emplid);
      empCell.innerHTML=eeListObj["empList"][emplid]["name"]+": "+eeListObj["empList"][emplid]["role"];
      addClass(empCell,"row"+rowClass);
      addClass(empCell,"multiVal");
      empCell.setAttribute("name",eeListObj["empList"][emplid]["type"]+":"+eeListObj["empList"][emplid]["payGrp"]+":"+eeListObj["empList"][emplid]["class"]);
      rowClass=3 - rowClass;
      rowNum++;
   }
   listDiv.appendChild(listTab);
   document.getElementById(destId).appendChild(listDiv);
}

function load_ee_letters(eeListObj, destId, objParms) {
   var destDivId = objParms["destDiv"];
   var destDiv = document.getElementById(destDivId);

   var empListDivId = destDivId + "_empList";
   var empListTblId = destDivId + "_empTab";
   var empAlphasId  = destDivId + "_empAlphas";

   var listDiv = document.createElement("div");
   listDiv.setAttribute("id", empAlphasId);  // objParms["alphaId"]);
   listDiv.setAttribute("listid", empListDivId); //objParms["listId"]);
   addClass(listDiv, "empAlphas");

   var letter=document.createElement("img");
   addClass(letter, "empChars");
   letter.setAttribute("letter","0");
   letter.setAttribute("src","./images/letterA.png");
   listDiv.appendChild(letter);

   var alphabet={"B":0,"C":0,"D":0,"E":0,"F":0,"G":0,"H":0,"I":0,"J":0,"K":0,"L":0,"M":0,"N":0,"O":0,"P":0,"Q":0,"R":0,"S":0,"T":0,"U":0,"V":0,"W":0,"X":0,"Y":0,"Z":0};

   for (theLetter in alphabet)
      if (eeListObj["letters"][theLetter]) {
         if (eeListObj["letters"][theLetter] > 0) {
            letter=document.createElement("img");
            addClass(letter, "empChars");
            letter.setAttribute("letter",eeListObj["letters"][theLetter]);
            letter.setAttribute("src","./images/letter" +theLetter+ ".png");
            listDiv.appendChild(letter);
         }
      }
   destDiv.appendChild(listDiv);
}

//Create the employee type buttons that appear at the top of the gith, employee list, column
function load_ee_buttons(eeListObj, destId, objParms) {
   var destDivId = objParms["destDiv"];
   var destDiv = document.getElementById(destDivId);

   var empButtsId = destDivId + "_empButts";

   var listDiv = document.createElement("div");
   listDiv.setAttribute("id", empButtsId);   // objParms["buttId"]);
   addClass(listDiv, "empListButts");

   var aButton;
   for (theButton in eeListObj["buttons"]) {
      aButton=document.createElement("img");
      aButton.setAttribute("src",eeListObj["buttons"][theButton]["img"]);
      aButton.setAttribute("eeType",eeListObj["buttons"][theButton]["opt"]);
      aButton.id = eeListObj["buttons"][theButton]["opt"];  //wmr
      addEvent(aButton,'click',loadEeList);
      listDiv.appendChild(aButton);
   }
   destDiv.appendChild(listDiv);
}

//who cares about shit they don't have the balls to say to your face

function xmlhttpPost(strURL, formName, resId) {
  var xmlHttpReq = false;
  var self = this;
  // Mozilla/Safari
  self.xmlHttpReq = get_xmlhttp();
  self.xmlHttpReq.open('POST', strURL, true);
  self.xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  self.xmlHttpReq.onreadystatechange = function() {
    if (self.xmlHttpReq.readyState == 4 && self.xmlHttpReq.status==200) {
        updatepage(self.xmlHttpReq.responseText, resId);
    }
  }
  self.xmlHttpReq.send(getquerystring(formName));
}

//   The following function obtains two variables from your form (email and message)
//   and builds a string that gets sent to your PHP script.  Change this function to
//   obtain whatever fields you want from your form.

function getquerystring(formName) {

    var qstr = '';
    var elem = document.getElementById(formName).elements;
    for(var i = 0; i < elem.length; i++) {
//    	alert(elem[i].name + "=" + escape(elem[i].value));
    	if (qstr == '')
           qstr += "" + elem[i].name + "=" + escape(elem[i].value);
        else
           qstr += "&" + elem[i].name + "=" + escape(elem[i].value);
    }
    return qstr;
}

function updatepage(str, resId){
    if (!resId)
       resId = "todoform";
    document.getElementById(resId).innerHTML = str;
}

function xmlhttpPost2(strURL, qryString, resId, doFunc) {
  var xmlHttpReq = false;
  var self = this;
  self.xmlHttpReq = get_xmlhttp();
  self.xmlHttpReq.open('POST', strURL, true);
  self.xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  self.xmlHttpReq.onreadystatechange = function() {
    if (self.xmlHttpReq.readyState == 4 && self.xmlHttpReq.status==200) {
      var aRes = self.xmlHttpReq.responseText;
      var firstR = aRes.split(" ")[0];
      var secondR = aRes.split(" ")[1];
      if (firstR == "Saved") {
        document.getElementById(resId).innerHTML = firstR;
        if (secondR) {
//        var jObj = JSON.parse(secondR);  wmr
          var jObj = eval('(' +secondR+ ')');
          document.getElementById('eventNum').innerHTML = jObj['eventNum'];
        }
      }
//    return firstR;   this doesn't work
      if (doFunc) {
        doFunc();
      } else {
        document.getElementById(resId).innerHTML = aRes;
      }
    }
      else
        document.getElementById(resId).innerHTML = "What the ??";
  }
  self.xmlHttpReq.send(qryString);
}

function xmlhttpPost2a(strURL, qryString, resId, doFunc) {
  var xmlHttpReq = false;
  xmlHttpReq = get_xmlhttp();
  xmlHttpReq.open('POST', strURL, true);
  xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xmlHttpReq.onreadystatechange = function() {
    if (xmlHttpReq.readyState == 4 && self.xmlHttpReq.status==200) {
      var aRes = xmlHttpReq.responseText;
      var firstR = aRes.split(" ")[0];
      var secondR = aRes.split(" ")[1];
      if (firstR == "Saved") {
        document.getElementById(resId).innerHTML = firstR;
        if (secondR) {
//        var jObj = JSON.parse(secondR);  wmr
          var jObj = eval('(' +secondR+ ')');
//        document.getElementById('eventNum').innerHTML = jObj['eventNum'];
        }
      }
//     return firstR;   this doesn't work
      if (doFunc) {
         doFunc();
      } else {
         document.getElementById(resId).innerHTML = aRes;
      }
    }
      else
        document.getElementById(resId).innerHTML = "What the ??";
  }
  xmlHttpReq.send(qryString);
}

function setEmplid(json) {
   var jsonObj=eval('(' +json+ ')');
   if (jsonObj["1"]) {
      var nextEmp = jsonObj["1"]["lastTempId"];
      }
   else
      var nextEmp = "error";
   document.getElementById('emplid').value=nextEmp;
}

function get_json_string(formName) {
    var json = {}, jsonRow={};
    var elem = document.getElementById(formName).elements;
    for(var i = 0; i < elem.length; i++) {
//    	alert(elem[i].name + "=" + escape(elem[i].value));
        jsonRow[elem[i].name] = escape(elem[i].value);
    }
    json["1"]=jsonRow;
    return json;
}

function saveFuncEmps(saveFunc, formName, resId) {
   var jsonFuncEmps = get_json_string(formName);
   xmlhttpPost3(saveFunc, jsonFuncEmps, resId);
}

// Submit a request that returns a request in a JSON formatted message.  Used in saves and such.
function xmlhttpPost3(strURL, jsonString, resId, doFunc) {
    var xmlHttpReq = false;
    var self = this;
    self.xmlHttpReq = get_xmlhttp();
    self.xmlHttpReq.open('POST', strURL, true);
    self.xmlHttpReq.setRequestHeader('Content-Type', 'application/json');
    self.xmlHttpReq.onreadystatechange = function() {
        if (self.xmlHttpReq.readyState == 4 && self.xmlHttpReq.status==200) {
            document.getElementById("hiddenData3").innerHTML = self.xmlHttpReq.responseText;
            var aRes = eval('(' +self.xmlHttpReq.responseText+ ')');
            if (aRes["result"] == "Saved")
               document.getElementById(resId).innerHTML = "Function Saved with " + aRes["rows"] + " entries.";
            else
               document.getElementById(resId).innerHTML = "Warning: " +aRes["result"] + " " + aRes["rows"] + " saved.";
            document.getElementById('eventNum').innerHTML = aRes["eventNum"];
            if (doFunc) {
               doFunc();
            }
        }
        else
           document.getElementById(resId).innerHTML = "Waiting ....";
    }
    self.xmlHttpReq.send(JSON.stringify(jsonString));
}

//Loop thourgh the dept list and add the click event to open the form.
function deptListEvents() {
   var deptList = document.getElementById("empsList");
   var childrenCnt = deptList.childNodes.length, chldNode;
   for (var i = 1, row; row = deptList.rows[i]; i++) {
       addEvent(row.cells[0].childNodes[0], 'click', doform);
            //.childNodes[0], 'click', doform);
    }
}

function deptEditEvent() {
   var deptList = document.getElementById("deptEdit");
   addEvent(deptList, 'click', doform);
}

//  This event forces only 1 checkbox to be on for the popup employee grid
function off_others(e) {
   e = e || window.event;
   if (e.target) var targ = e.target;
   else if (e.srcElement) var targ = e.srcElement;

   document.getElementById('chkRep').checked=false;
   document.getElementById('chkIns').checked=false;
//   document.getElementById('chkEnd').checked=false;

   targ.checked=true;
}

//Events for the pop-up employee list
function empList_Events(objParms) {
  var destDivId = objParms["destDiv"];
  var destDiv = document.getElementById(destDivId);

  var empListDivId = destDivId + "_empList";
  var empListTblId = destDivId + "_empTab";
  var empAlphasId  = destDivId + "_empAlphas";

   var empList2 = document.getElementById(empListDivId).childNodes[0]; //listObj["listId"]).childNodes[0];  //"empList2");
   var childrenCnt = empList2.childNodes.length, chldNode;
   for (var i = 0, row; row = empList2.rows[i]; i++) {
       addEvent(row.cells[0], 'click', popup_ee);
    }
   addEvent(document.getElementById('chkRep'), 'click', off_others);
   addEvent(document.getElementById('chkIns'), 'click', off_others);
//   addEvent(document.getElementById('chkEnd'), 'click', off_others);
}

function formDeptEvents() {
   addEvent(document.getElementById("deptPrevButt"), "click", doform);
   addEvent(document.getElementById("deptNextButt"), "click", doform);
   addEvent(document.getElementById("deptAddButt"), "click", doform);
}

function formButtEvents() {
   addEvent(document.getElementById("editPrevButt"), "click", doform);
   addEvent(document.getElementById("editNextButt"), "click", doform);
   addEvent(document.getElementById("editAddButt"), "click", doform);
}

function addUnitRow(e) {
   e = e || window.event;
   if (e.target) var targ = e.target;
   else if (e.srcElement) var targ = e.srcElement;

	alert("Add");
}

function remUnitRow(e) {
   e = e || window.event;
   if (e.target) var targ = e.target;
   else if (e.srcElement) var targ = e.srcElement;

   var currIdx = targ.parentNode.parentNode.rowIndex;
	alert("Remove " +currIdx );
}

function formUserSecEvents() {
   formButtEvents();
   addEvent(document.getElementById("addUnitRow"), "click", addUnitRow);
   var unitList = document.getElementById("secUnits");
   var childrenCnt = unitList.childNodes.length, chldNode;
   for (var i = 1, row; row = unitList.rows[i]; i++) {
       addEvent(row.cells[1], 'click', remUnitRow);
    }
}

function xmlhttpPost4(strURL, jsonString, resId, doFunc) {
    var xmlHttpReq = false;
    var self = this;
    self.xmlHttpReq = get_xmlhttp();
    self.xmlHttpReq.open('POST', strURL, true);
    self.xmlHttpReq.setRequestHeader('Content-Type', 'application/json');
    self.xmlHttpReq.onreadystatechange = function() {
        if (self.xmlHttpReq.readyState == 4 && self.xmlHttpReq.status==200) {
            document.getElementById(resId).innerHTML = self.xmlHttpReq.responseText;
            if (doFunc) {
               doFunc();
            }
        }
        else
           document.getElementById(resId).innerHTML = strURL + " has Failed";
    }
    self.xmlHttpReq.send(JSON.stringify(jsonString));
}
//
// like Post4, except returns json as well
//
function ajax_post(strURL, jsonString, resId, jsonFunc) {
  var xmlHttpReq = false;
  xmlHttpReq = get_xmlhttp();
  xmlHttpReq.open('POST', strURL, true);
  xmlHttpReq.setRequestHeader('Content-Type', 'application/json');
  xmlHttpReq.onreadystatechange = function() {
    if (xmlHttpReq.readyState == 4 && xmlHttpReq.status==200) {
      var json = xmlHttpReq.responseText;
      jsonFunc(json);
    } else
      document.getElementById(resId).innerHTML = strURL + " has Failed";
  }
  xmlHttpReq.send(JSON.stringify(jsonString));
}

function getTempId(unitId) {
   jsonAjax("jsonGetNextTemp", setEmplid, unitId, '');
}

function saveEmp() {
	var getParms = getquerystring("formEmps");
	xmlhttpPost2("saveEmps.php", getParms, "statusRes");
}
//
// Submit a GET request that returns a request in a JSON formatted message.
//
function jsonAjax(servFunc, jsonFunc, unitId, parm1) {
  var xmlHttpReq = false;
  xmlHttpReq = get_xmlhttp();
  xmlHttpReq.open('GET', ""+servFunc+".php?unitId=" + unitId + "&parm1=" + parm1, true);
  xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xmlHttpReq.onreadystatechange = function() {
    if (xmlHttpReq.readyState == 4 && xmlHttpReq.status==200) {
      var json = xmlHttpReq.responseText;
      jsonFunc(json);
    }
  }
  xmlHttpReq.send();
}

function jsonAjax2(servFunc, jsonFunc, unitId, addlParms) {
    var xmlHttpReq = false;
    xmlHttpReq = get_xmlhttp();
    xmlHttpReq.open('GET', ""+servFunc+"?unitId=" + unitId + addlParms, true);
    xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlHttpReq.onreadystatechange = function() {
        if (xmlHttpReq.readyState == 4 && xmlHttpReq.status==200) {
            var json = xmlHttpReq.responseText;
            jsonFunc(json);
        }
    }
    xmlHttpReq.send();
}

function get_emp_type_info(eeType) {
    var json =  eval('(' +document.getElementById("empTypeOpts").innerHTML+ ')');
    var eeTypeObj = json[eeType];
    return eeTypeObj;
}

// Using the calculation info stored in the hidden2 area, determine the compuration method for the given function, emp type, and gratity type
function get_calc_method(funcType, eeType, gratType) {
  var jsonCalcComp = eval('(' +document.getElementById("calcComp").innerHTML+ ')');
//  alert("Get for " +funcType+ " and " + eeType+ " for " +gratType);
  if (jsonCalcComp[funcType])
     if (jsonCalcComp[funcType][eeType])
        if (jsonCalcComp[funcType][eeType][gratType])
           return jsonCalcComp[funcType][eeType][gratType]["calcMeth"];
        else
           return "#g";
     else
        return "#e";
  else
     return "#f";
}

function get_unit_data(unitId) {
  var jsonUnit = eval('(' +document.getElementById("unitData").innerHTML+ ')');
//  alert("Get for " +funcType+ " and " + eeType+ " for " +grat);
  if (jsonUnit[unitId])
     return jsonUnit[unitId];
  else
     return {};
}

function get_payGrp_data() {
  var jsonPG = eval('(' +document.getElementById("payGrps").innerHTML+ ')');
//  alert("Get for " +funcType+ " and " + eeType+ " for " +grat);
  if (jsonPG)
     return jsonPG;
  else
     return {};
}

function get_ecMeth() {
   var unitId=document.getElementById('unitId').innerHTML.split(" ")[1];
   var unitData = get_unit_data(unitId);
   var ecMeth = unitData["ecMeth"];
   return ecMeth;
}

function get_payGrp_emplClass(payGrp) {
   var payGrpData = get_payGrp_data();
   var emplClass = payGrpData[payGrp]["emplClass"];
   return emplClass;
}

// When the function type changes, the hidden data for base wages (by empl class) must be updated.
function hideBW(jsonStr) {
  var bwList = eval('(' +jsonStr+ ')'), newDiv;
  var hideArea = document.getElementById("hiddenData");
  for (var objNum in bwList) {
     json = bwList[objNum];
     newDiv = document.createElement('div');
     newDiv.setAttribute("id","empClass"+json["emplClass"]);
     newDiv.innerHTML = json["baseWage"];
     hideArea.appendChild(newDiv);
     }
  newDiv = document.createElement('div');
  newDiv.setAttribute("id","empClass");
  newDiv.innerHTML = "0";
  hideArea.appendChild(newDiv);
  loopGrid(setBaseWage);
}

function get_baseWage(emplClass, payGrp) {
   var ecMeth = get_ecMeth();
//  alert("Get bw for " + emplClass + " and " + payGrp + "ec meth:" + ecMeth);
   if (ecMeth == "2")
      emplClass=get_payGrp_emplClass(payGrp);
   if (document.getElementById("empClass"+emplClass))
      return document.getElementById("empClass"+emplClass).innerHTML;
   else
      return 0;
}

function setBaseWage(empRow) {
//   var eeType = empRow.cells[3].childNodes[0].value;
//   var emplClass="";
   var typeDetails = {};
   typeDetails["eeType"] = empRow.cells[3].childNodes[0].value;
   getEeTypeDets(typeDetails);
//   if (ecMeth == "1")
//      emplClass=typeDetails["emplClass"];
//   else
//      emplClass=get_payGrp_emplClass(empRow.cells[1].getAttribute("name").split(":")[2]);
//
//   if (document.getElementById("empClass"+emplClass)) {
//      var bw = document.getElementById("empClass"+emplClass).innerHTML;
//   } else {
//      var bw = 0;
//   }

   var bw = get_baseWage(empRow.cells[1].getAttribute("name").split(":")[2], empRow.cells[1].getAttribute("name").split(":")[1]);
   var bwCell = empRow.cells[9];
   removeKids(bwCell);
   if (typeDetails["eeBaseWage"] == "Y") {
      bwCell.innerHTML='<input type="text" class="numfld" id = "bw'+ empRow.cells[1].innerHTML + '" size="5" value="'+bw+'"/>';
      addEvent(document.getElementById('bw'+empRow.cells[1].innerHTML), 'change', calcGrid);
   } else {
      bwCell.innerHTML='<input type="text" class="numfld" id = "bw'+ empRow.cells[1].innerHTML + '" size="5" value="0" readonly/>';
   }
}
//
// Match up a value in an select/dropdown field to the corresponding option tag to get an attribute value from that option tag
//
function getOption(elm, selectedVal, attrib) {
  var childrenCnt = elm.childNodes.length, chldNode;
  if (childrenCnt > 0) {
    for (var i = 0; i < childrenCnt; i++) {
    	chldNode = elm.childNodes[i];
	    if (chldNode.getAttribute(attrib))
	      if (chldNode.value == selectedVal) {
	 	      return chldNode.getAttribute(attrib);
	      }
	  }
    return "0";
  }
   else
    return "0";
}

function testEvent(e) {
	alert("Test Event fired" +e);
	return false;
}
//
//  Executed upon a change to the Func Type field
//
function funcDateChange(e) {
  e = e || window.event;
  if (e.target) var targ = e.target;
  else if (e.srcElement) var targ = e.srcElement;

  alert("Date chnged");
}
//
//  Executed upon a change to the Func Type field
//
function funcChange(e) {
  e = e || window.event;
  if (e.target) var targ = e.target;
  else if (e.srcElement) var targ = e.srcElement;

  removeKids(document.getElementById('hiddenData'));
  var unitId = document.getElementById("unitId").innerHTML.split(" ")[1];
//  jsonAjax("jsonGetFuncCons", hideBW, unitId, document.getElementById("funcType").value);
  jsonAjax2("jsonGetFuncCons.php", hideBW, unitId, "&funcType=" + document.getElementById("funcType").value + "&funcDate=" + document.getElementById("funcDate").value);
  var prevCovers = document.getElementById("defCovers").innerHTML;

  var newCovers = getOption(targ, document.getElementById("funcType").value, "covers");
  document.getElementById("defCovers").innerHTML=newCovers;
  loopGrid(function (row) {
    if (row.cells[7].childNodes[0].value == prevCovers && row.cells[1].getAttribute("name").split(":")[7] == "Y") {
      row.cells[7].childNodes[0].value = newCovers;
      }
  });
  calcGrid();
  jsonAjax2("jsonGetFuncNum.php", setFuncNum, unitId, "&funcType=" + document.getElementById("funcType").value + "&eventNum=" + document.getElementById("eventNum").innerHTML);
}
//
// Set the Function Number for the week based on the value returned from procedure jsonGetFuncNum.
//
function setFuncNum(json){
  var funcNum = document.getElementById("funcNumWk");
  var jsonFunc = eval('(' +json+ ')');
  if (jsonFunc["result"] == "Success") {
    funcNum.value = jsonFunc["nextFunc"];
  } else {

  }
}

function evalFuncChange(json) {
   var jsonFunc = eval('(' +json+ ')');
   if (jsonFunc["exists"] == "yes") {
      popup("Function Number in use (" +jsonFunc["eventNum"]+ ") has " +jsonFunc["empCnt"]+ " employees assigned.","OK", okButt);
      document.getElementById("funcNumWk").value = "";
   } else {
   }
}

function funcNumChange(e) {
   e = e || window.event;
   if (e.target) var targ = e.target;
   else if (e.srcElement) var targ = e.srcElement;

   var unitId = document.getElementById("unitId").innerHTML.split(" ")[1];
  jsonAjax("jsonGetFuncInfo", evalFuncChange, unitId, document.getElementById("funcNumWk").value);
//  var jsonUnit = eval('(' +document.getElementById("unitData").innerHTML+ ')');
}

function use_bodies() {
   var unitId   = document.getElementById("unitId").innerHTML.split(" ")[1];
   var unitData = eval('(' +document.getElementById("unitData").innerHTML+ ')');
   if (unitData[unitId]["useBodies"] == "Y")
       return true;
   else
       return false
}

// given a numeric eeType return the plural ee type description as given in hidden data object
function get_emp_descr(eeType){
   var eeData = get_emp_type_info(eeType)
   if (typeof eeData["eeTypePlr"] != "undefined")
       return eeData["eeTypePlr"];
   else
       return "unknown(" +eeType+ ")";
}

//Count the number of eeTypes in the employee gridf or the given eeType
function get_bodies_cnt(eeType) {
   if (use_bodies()) {

      var empGrid = document.getElementById('empGridBody');    //Get the table tag that holds the list of employees
      var bods=0;
      for (var i = 0, row; row = empGrid.rows[i]; i++) {
         if (row.cells[3].childNodes[0].value == eeType)
            bods = bods + parseFloat(row.cells[8].childNodes[0].value);
      }
     return bods;
   } else {
     return 0; }
}

function edit_bodies(editType) {
//      alert ("Bodies Field is " +isBodies);
   if (use_bodies()) {
     var bodiesTab  = document.getElementById('bodiesTab');
     var bodiesRows = bodiesTab.rows.length;
     for (var i=0; i<bodiesRows; i++) {
        var eeType = bodiesTab.rows[i].cells[1].childNodes[0].getAttribute("eetype");
        var gridBodies = get_bodies_cnt(eeType);
        if (editType == "eq" && gridBodies != parseFloat(bodiesTab.rows[i].cells[1].childNodes[0].value))
            popup("Number of bodies entered (" +gridBodies+ ") does not match given count (" +parseFloat(bodiesTab.rows[i].cells[1].childNodes[0].value)+ ") for "+ get_emp_descr(eeType) +".", "OK", okButt);
        if (editType == "gt" && gridBodies > parseFloat(bodiesTab.rows[i].cells[1].childNodes[0].value))
            popup("Number of bodies entered (" +gridBodies+ ") is more than given count (" +parseFloat(bodiesTab.rows[i].cells[1].childNodes[0].value)+ ") for "+ get_emp_descr(eeType) +".", "OK", okButt);
     }
   }
}

function saveGrid(eType) {
   edit_bodies("eq");
   document.getElementById('statusResult').innerHTML = "";
   if (document.getElementById('funcDate').value == "")
      popup("Function Date is required before saving.", "OK", okButt);
   else
     if (document.getElementById('funcNumWk').value == "")
        popup("Function Number for the week is required before saving.", "OK", okButt);
      else
        if (document.getElementById('defCovers').innerHTML !== "0")
           if (document.getElementById('totCovers').value == "" || document.getElementById('totCovers').value == "0")
              popup("Total covers is required before saving.", "OK", okButt);
           else
              if (document.getElementById('totCovers').value !== document.getElementById('empGridTots').rows[0].cells[6].childNodes[0].value)
                 popup("Covers do not match.", "OK", okButt);
              else {
                 document.getElementById('statusResult').innerHTML = "Error saving function?";
                 func_is_saved(function() {ungrey_page();});
                 eventSaved();
      	         saveFunc2();
              }
        else {
                 document.getElementById('statusResult').innerHTML = "Error saving function?";
                 func_is_saved(function() {ungrey_page();});
                 eventSaved();
      	         saveFunc2();
              }
}

function func_is_saved(f) {
  func_is_saved.saved = false;
  func_is_saved.checks=0;
  if (func_is_saved.timer) {
  	func_is_saved.ready.push(f);
  } else {
  	func_is_saved.ready = [f];
  	func_is_saved.timer=setInterval(is_func_saved,500);
  }
}

function is_func_saved() {
  grey_page();
  var statusResult = document.getElementById('statusResult').innerHTML.substring(0,14);
  if (statusResult == "Function Saved" || func_is_saved.checks > 120) {
    func_is_saved.saved = true;
    clearInterval(func_is_saved.timer);
    func_is_saved.timer=null;
    for (var i=0; i<func_is_saved.ready.length;  i++)
       func_is_saved.ready[i]();
    func_is_saved.ready=null;
    func_is_saved.timer=null;
    if (func_is_saved.checks > 120)
       popup("It appears that the function did not save.","OK",okButt);
  } else
  	func_is_saved.checks++;
}

function get_bods_rows(appendObj) {
   if (use_bodies()) {
     var bodiesTab  = document.getElementById('bodiesTab');
     var bodRows={};
     var bodiesRows = bodiesTab.rows.length;
     for (var i=0; i<bodiesRows; i++) {
        var eeType = bodiesTab.rows[i].cells[1].childNodes[0].getAttribute("eetype");
        var gridBodies = bodiesTab.rows[i].cells[1].childNodes[0].value;
        bodRows[eeType]= gridBodies;
     }
     appendObj["numbodies"] = bodRows;
   }
   return appendObj;
}

//Add the contents of the Gratuities Grid to a passed object in order to save the data.
function get_grat_rows(appendObj) {
   var gratsGrid = document.getElementById("gratsGrid");
   var gratCnt=0, row;
   var gratsLen = gratsGrid.rows.length;
   for (var i = 0; i < gratsLen; i++) {
      row = gratsGrid.rows[i];
      jsonGridRow ={};
      if (row.cells[0].childNodes[0].value != "X") {
      	 jsonGridRow["gratSeq"]      = i;
         jsonGridRow["gratType"]     = row.cells[0].childNodes[0].value;
         jsonGridRow["checkNum"]     = row.cells[2].childNodes[0].value;  //should this be child?
         jsonGridRow["checkAmt"]     = row.cells[4].childNodes[0].value;  //or these?
         jsonGridRow["gratAmt"]      = row.cells[6].childNodes[0].value;
         jsonGridRow["gratAddl"]     = row.cells[8].childNodes[0].value;
//         gratCnt++;
         appendObj["grat" + i] = jsonGridRow;
      }
   }
   return appendObj;
}

function saveFunc2() {
   var qstr, unitId, eventNum;
   var empGrid = document.getElementById('empGridTab');    //Get the table tag that holds the list of employees
   var eventNum = document.getElementById('eventNum').innerHTML;    //Get the table tag that holds the list of employees
   var unitId = document.getElementById('unitId').innerHTML.split(" ")[1];
   var jsonGrid = {};
   var jsonGridRow;

   qstr  = "&funcDate="  + escape(document.getElementById('funcDate').value);
   qstr += "&wkendDate=" + escape(document.getElementById('wkendDate').innerHTML.split(" ")[1]);
   qstr += "&roomNum="   + escape(document.getElementById('roomNum').value);
   qstr += "&funcType="  + escape(document.getElementById('funcType').value);
   qstr += "&funcGroup=" + escape(document.getElementById('funcGroup').value);
   qstr += "&funcNumWk=" + escape(document.getElementById('funcNumWk').value);
   qstr += "&funcNumWk=" + escape(document.getElementById('funcNumWk').value);

   qstr += "&grat1Type=" + escape(document.getElementById('grat1').value);
   qstr += "&grat1Chk="  + escape(document.getElementById('grat1Chk').value);
   qstr += "&grat1Bill=" + escape(document.getElementById('grat1Bill').value);
   qstr += "&grat1Grat=" + escape(document.getElementById('grat1Grat').value);
   qstr += "&grat1Addl=" + escape(document.getElementById('grat1Addl').value);

   qstr += "&grat2Type=" + escape(document.getElementById('grat2').value);
   qstr += "&grat2Chk="  + escape(document.getElementById('grat2Chk').value);
   qstr += "&grat2Bill=" + escape(document.getElementById('grat2Bill').value);
   qstr += "&grat2Grat=" + escape(document.getElementById('grat2Grat').value);
   qstr += "&grat2Addl=" + escape(document.getElementById('grat2Addl').value);

   qstr += "&grat3Type=" + escape(document.getElementById('grat3').value);
   qstr += "&grat3Chk="  + escape(document.getElementById('grat3Chk').value);
   qstr += "&grat3Bill=" + escape(document.getElementById('grat3Bill').value);
   qstr += "&grat3Grat=" + escape(document.getElementById('grat3Grat').value);
   qstr += "&grat3Addl=" + escape(document.getElementById('grat3Addl').value);

   qstr += "&totCovers=" + escape(document.getElementById('totCovers').value);
   qstr += "&defSetup="  + escape(document.getElementById('defSetup').value);
   qstr += "&defClear="  + escape(document.getElementById('defClear').value);
   qstr += "&defExtra="  + escape(document.getElementById('defExtra').value);

   qstr += "&rateDate="  + escape(document.getElementById('rateDate').value);

   if (eventNum == "undefined" || eventNum == "" || eventNum == "0") {
   	document.getElementById('statusResult').innerHTML = "ERROR: Event Number Missing";
   } else {
      var qstr, cutFlags;
      for (var i = 1, row; row = empGrid.rows[i]; i++) {
     	 document.getElementById('statusResult').innerHTML = "Still Saving: " + escape(row.cells[0].innerHTML);
         jsonGridRow ={};
//         jsonGridRow["eventNum"]   = eventNum;
         jsonGridRow["empSeq"]     = row.cells[0].innerHTML;
         jsonGridRow["emplid"]     = row.cells[1].innerHTML;
         jsonGridRow["eeType"]     = row.cells[3].childNodes[0].value;
         cutFlags = row.cells[1].getAttribute("name").split(":");
         jsonGridRow["payGrp"]     = cutFlags[1];
         jsonGridRow["emplClass"]  = cutFlags[2];
         jsonGridRow["getSetup"]   = cutFlags[3];
         jsonGridRow["getClear"]   = cutFlags[4];
         jsonGridRow["getExtra"]   = cutFlags[5];
         jsonGridRow["eeBaseWage"] = cutFlags[6];

         jsonGridRow["grat1Type"]  = row.cells[4].innerHTML;
         jsonGridRow["grat1Group"] = row.cells[4].getAttribute("group");
         jsonGridRow["grat1Rate"]  = row.cells[4].getAttribute("cutrate");
         jsonGridRow["grat1Cut"]   = row.cells[14].childNodes[0].value;

         jsonGridRow["grat2Type"]  = row.cells[5].innerHTML;
         jsonGridRow["grat2Group"] = row.cells[5].getAttribute("group");
         jsonGridRow["grat2Rate"]  = row.cells[5].getAttribute("cutrate");
         jsonGridRow["grat2Cut"]   = row.cells[15].childNodes[0].value;

         jsonGridRow["grat3Type"]  = row.cells[6].innerHTML;
         jsonGridRow["grat3Group"] = row.cells[6].getAttribute("group");
         jsonGridRow["grat3Rate"]  = row.cells[6].getAttribute("cutrate");
         jsonGridRow["grat3Cut"]   = row.cells[16].childNodes[0].value;

         jsonGridRow["coversAllowed"] = cutFlags[7];
         jsonGridRow["eeCovers"]   = row.cells[7].childNodes[0].value;
         jsonGridRow["eeWeight"]   = row.cells[8].childNodes[0].value;
         jsonGridRow["baseWage"]   = row.cells[9].childNodes[0].value;
         jsonGridRow["hours"]      = row.cells[10].childNodes[0].value;
         jsonGridRow["setupAmt"]   = row.cells[11].childNodes[0].value;
         jsonGridRow["clearAmt"]   = row.cells[12].childNodes[0].value;
         jsonGridRow["extraAmt"]   = row.cells[13].childNodes[0].value;
         jsonGridRow["totalPay"]   = row.cells[17].childNodes[0].value;
         jsonGrid[i] = jsonGridRow;
      }
      jsonGrid = get_grat_rows(jsonGrid);
      jsonGrid = get_bods_rows(jsonGrid);
      xmlhttpPost3('saveFunc2.php?unitId=' +unitId+ '&eventNum=' + eventNum + qstr, jsonGrid, "statusResult");
   }
}

function load_grat_types_obj() {
   gratTypesGbl = eval('(' +document.getElementById("gratTypes").innerHTML+ ')');
}

// By Staff Counts
function calc1(empGroup, totGrat, cutPercent ) {
   var empCnt, eeGrat;
   if (empGroup != "")                            //Get the group counts from the employee count frame
      empCnt   = document.getElementById('empCnt' + empGroup).innerHTML.split(':')[1];
   else
      empCnt   = 0;

   if (empCnt > 0)
      eeGrat = Math.round(parseFloat(cutPercent / empCnt * totGrat)) / 100;
   else
      eeGrat = 0;
   return eeGrat;
}

// By Covers
function calc2(totCovers, eeCovers, totGrat, cutPercent) {
   if (totCovers > 0) {
      var TPC = parseFloat(totGrat * cutPercent / 100 / totCovers);
   } else {
      var TPC = 0;
   }
   var eeGrat = Math.round(parseFloat(TPC * eeCovers * 100)) / 100;
//   alert("Tot Covers " + totCovers + " food rate " + foodRate + " bar rate " + barRate + " FTPC: " + FTPC + " BTPC: " + BTPC);
   return eeGrat;
}
//
// By Hours - Coffee Break
//
//  (Hours worked) /(Total Hours for Employee Group) * (Total Gratuity) * (Employee Group Percent/Cut)
//
function calc5(empGroup, eeHours, totGrat, cutPercent, i) {
   var empCnt, totHours, eeGrat=0;
   totHours = get_tot_hours();
   if (empGroup != "")                            //Get the group counts from the employee count frame
      empCnt   = document.getElementById('empCnt' + empGroup).innerHTML.split(':')[1];
   else
      empCnt   = 0;

   if (empCnt > 0)
    if (eeHours > 0) {
//      alert("Comp" + cutPercent + " " + totGrat + " " + eeHours + " " + totHours + " i:" + i);
      eeGrat = Math.round(parseFloat(cutPercent * totGrat * eeHours / totHours)) / 100;
      }
    else
       eeGrat = 0;
   else
      eeGrat = 0;
   return eeGrat;
}

function accumTots(row) {
//   var foodGrat = cells[13].childNodes[0].value;
//   var barGrat  = cells[14].childNodes[0].value;

//   document.getElementById('foodTotal').innerHTML = ;
//   document.getElementById('barTotal').innerHTML = ;
//
//  Compute just the total hours for the grids.  Total hours is used for Coffee Break computations.
//
}
function comp_total_hours() {
   var empGrid = document.getElementById('empGridTab');    //Get the table tag that holds the list of employees
   var gridTotsArr = [0,0,0,0,0,0,0,0,0,0,0,0];
   for (var i = 1, row; row = empGrid.rows[i]; i++) {
      gridTotsArr[0] = gridTotsArr[0] + 1;
      gridTotsArr[4] = gridTotsArr[4] + parseFloat(row.cells[10].childNodes[0].value);
   }
   var totLine = document.getElementById('empGridTots');
   totLine.rows[0].cells[5].childNodes[0].value = Math.round(gridTotsArr[0]);   //Total number of employees
   totLine.rows[0].cells[9].childNodes[0].value = Math.round(gridTotsArr[4] * 100) / 100;           //Hours Total
}
//
//  This function computes the totals for each column in the grid 
//
function gridTots() {
   var empGrid = document.getElementById('empGridTab');    //Get the table tag that holds the list of employees
   var gridTotsArr = [0,0,0,0,0,0,0,0,0,0,0,0];
   for (var i = 1, row; row = empGrid.rows[i]; i++) {
      gridTotsArr[0] = gridTotsArr[0] + 1;
      gridTotsArr[1] = gridTotsArr[1] + parseFloat(row.cells[7].childNodes[0].value); // * parseFloat(row.cells[7].childNodes[0].value);
      gridTotsArr[2] = gridTotsArr[2] + parseFloat(row.cells[8].childNodes[0].value);
      gridTotsArr[3] = gridTotsArr[3] + parseFloat(row.cells[9].childNodes[0].value);
      gridTotsArr[4] = gridTotsArr[4] + parseFloat(row.cells[10].childNodes[0].value);
      gridTotsArr[5] = gridTotsArr[5] + parseFloat(row.cells[11].childNodes[0].value);
      gridTotsArr[6] = gridTotsArr[6] + parseFloat(row.cells[12].childNodes[0].value);
      gridTotsArr[7] = gridTotsArr[7] + parseFloat(row.cells[13].childNodes[0].value);
      gridTotsArr[8] = gridTotsArr[8] + parseFloat(row.cells[14].childNodes[0].value);
      gridTotsArr[9] = gridTotsArr[9] + parseFloat(row.cells[15].childNodes[0].value);
      gridTotsArr[10] = gridTotsArr[10] + parseFloat(row.cells[16].childNodes[0].value);
      gridTotsArr[11] = gridTotsArr[11] + parseFloat(row.cells[17].childNodes[0].value);
   }
   var totLine = document.getElementById('empGridTots');
   totLine.rows[0].cells[5].childNodes[0].value = Math.round(gridTotsArr[0]);
   for (var i = 1, cell; cell = totLine.rows[0].cells[i+5]; i++) {
   	cell.childNodes[0].value = Math.round(gridTotsArr[i] * 100) / 100;
   }
}
//
//  This function computs the total pay amount on a line (ie, for an employee)
//
function total_grid_line(row) {
   var gridLineTot = 0;
   gridLineTot = gridLineTot + parseFloat(row.cells[9].childNodes[0].value);   //Base Wage
   gridLineTot = gridLineTot + parseFloat(row.cells[11].childNodes[0].value);  //Setup Amount
   gridLineTot = gridLineTot + parseFloat(row.cells[12].childNodes[0].value);  //Clear Amount
   gridLineTot = gridLineTot + parseFloat(row.cells[13].childNodes[0].value);  //Extra Amount
   gridLineTot = gridLineTot + parseFloat(row.cells[14].childNodes[0].value);  //Grat 1 (food)
   gridLineTot = gridLineTot + parseFloat(row.cells[15].childNodes[0].value);  //Grat 2 (bar)
   gridLineTot = gridLineTot + parseFloat(row.cells[16].childNodes[0].value);  //Grat 3 (wine)
   row.cells[17].childNodes[0].value = Math.round(gridLineTot * 100) / 100;
}

//Event driven
function total_grid_row(e) {
   e = e || window.event;
   if (e.target) var targ = e.target;
   else if (e.srcElement) var targ = e.srcElement;
   
 // alert("Total Grid");

   if (hasClass(targ, "numfld")) {
      var row = targ.parentNode.parentNode;
      total_grid_line(row);
   }
}

// This will adjust the Food gratuity allocation for the sole Net account
function netGrat1(row) {
   if (document.getElementById('grat1Grat').value == "")
      document.getElementById('grat1Grat').value = 0.00;
   if (hasClass(row.cells[4], "netAcct")) {
      var foodGrat = parseFloat(document.getElementById('grat1Grat').value);
      foodGrat = foodGrat + parseFloat(document.getElementById('grat1Addl').value);
//      var wineGrat  = document.getElementById('wineGrat').value;
//      foodGrat = parseFloat(foodGrat) + parseFloat(wineGrat);
      var netAmt = parseFloat(row.cells[14].childNodes[0].value);
      var totLine = document.getElementById('empGridTots');
      var computedGrat = parseFloat(totLine.rows[0].cells[13].childNodes[0].value);
      var diffGrat = Math.round((foodGrat - computedGrat) * 100) / 100;
      var newGrat = Math.round((netAmt + diffGrat) * 100) / 100;
      row.cells[14].childNodes[0].value = newGrat;
      row.cells[14].setAttribute("title","Net adjusted by " + diffGrat);
      total_grid_line(row);
      gridTots();
   }
}

// This will adjust the Bar gratuity allocation for the sole Net account
function netGrat2(row) {
   if (document.getElementById('grat2Grat').value == "")
      document.getElementById('grat2Grat').value = 0.00;
   if (hasClass(row.cells[5], "netAcct")) {
      var barGrat = parseFloat(document.getElementById('grat2Grat').value);
      barGrat = barGrat + parseFloat(document.getElementById('grat2Addl').value);
      var netAmt = parseFloat(row.cells[15].childNodes[0].value);
      var totLine = document.getElementById('empGridTots');
      var computedGrat = parseFloat(totLine.rows[0].cells[14].childNodes[0].value);
      var diffGrat = Math.round((barGrat - computedGrat) * 100) / 100;
      var newGrat = Math.round((netAmt + diffGrat) * 100) / 100;
      row.cells[15].childNodes[0].value = newGrat;
      row.cells[15].setAttribute("title","Net adjusted by " + diffGrat);
      total_grid_line(row);
      gridTots();
   }
}

// This will adjust the Bar gratuity allocation for the sole Net account
function netGrat3(row) {
   if (document.getElementById('grat3Grat').value == "")
      document.getElementById('grat3Grat').value = 0.00;
   if (hasClass(row.cells[6], "netAcct")) {
      var barGrat = parseFloat(document.getElementById('grat3Grat').value);
      barGrat = barGrat + parseFloat(document.getElementById('grat3Addl').value);
      var netAmt = parseFloat(row.cells[16].childNodes[0].value);
      var totLine = document.getElementById('empGridTots');
      var computedGrat = parseFloat(totLine.rows[0].cells[15].childNodes[0].value);   //tot line is off by 1
      var diffGrat = Math.round((barGrat - computedGrat) * 100) / 100;
      var newGrat = Math.round((netAmt + diffGrat) * 100) / 100;
      row.cells[16].childNodes[0].value = newGrat;
      row.cells[16].setAttribute("title","Net adjusted by " + diffGrat);
      total_grid_line(row);
      gridTots();
   }
}

function calcGrid(eType) {
//  alert(arguments.callee.caller.name );
   document.getElementById("statusResult").innerHTML='';
   var empGrid = document.getElementById('empGridBody');    //Get the table tag that holds the list of employees
   var compMethod, rownum, empCnt, eeType, tot, cut1, cut2, setupAmt, clearAmt, extraAmt, eeCovers, eeWeight, eeHours;
   var empCnt, cutFlags, empType, tot,  cut1Grand=0, cut2Grand=0, cut3Grand=0, setupAmt, clearAmt, extraAmt;
   var grat1NetCnt=0, grat2NetCnt=0, grat3NetCnt=0;
   var grat1CutRate,  grat2CutRate,  grat3CutRate;
   var funcType = document.getElementById("funcType").value;
   var totCovers = document.getElementById('totCovers').value;
   var coversCnt=0, rowCnt=0;
   var grat1 = document.getElementById('grat1').value;
   var grat2 = document.getElementById('grat2').value;
   var grat3 = document.getElementById('grat3').value;
   var grat1Amt = parseFloat(document.getElementById('grat1Grat').value);
   var grat1Addl = parseFloat(document.getElementById('grat1Addl').value);
   grat1Amt = parseFloat(grat1Amt) + parseFloat(grat1Addl);
   var grat2Amt = parseFloat(document.getElementById('grat2Grat').value);
   var grat2Addl = parseFloat(document.getElementById('grat2Addl').value);
   grat2Amt = parseFloat(grat2Amt) + parseFloat(grat2Addl);
   var grat3Amt  = parseFloat(document.getElementById('grat3Grat').value);
   var grat3Addl = parseFloat(document.getElementById('grat3Addl').value);
   grat3Amt = parseFloat(grat3Amt) + parseFloat(grat3Addl);
   for (var i = 0, row; row = empGrid.rows[i]; i++) {
      var grat1Group  = row.cells[4].getAttribute("group");
      var grat2Group  = row.cells[5].getAttribute("group");
      var grat3Group  = row.cells[6].getAttribute("group");
      if (grat1Group != "")                            //Get the group counts from the employee count frame
         grat1EmpCnt   = document.getElementById('empCnt' + grat1Group).innerHTML.split(':')[1];
      else
         grat1EmpCnt   = 0;
      if (grat2Group != "")
         grat2EmpCnt    = document.getElementById('empCnt' + grat2Group).innerHTML.split(':')[1];
      else
         grat2EmpCnt   = 0;
      if (grat3Group != "")
         grat3EmpCnt    = document.getElementById('empCnt' + grat3Group).innerHTML.split(':')[1];
      else
         grat3EmpCnt   = 0;

      eeType = row.cells[3].childNodes[0].value;

      grat1CutRate  = parseFloat(row.cells[4].getAttribute("cutrate"));
      if (hasClass(row.cells[4], "netAcct"))
         grat1NetCnt++;

      grat2CutRate  = parseFloat(row.cells[5].getAttribute("cutrate"));
      if (hasClass(row.cells[5], "netAcct"))
         grat2NetCnt++;

      grat3CutRate  = parseFloat(row.cells[6].getAttribute("cutrate"));
      if (hasClass(row.cells[6], "netAcct"))
         grat3NetCnt++;

      eeCovers = parseFloat(row.cells[7].childNodes[0].value);
      eeWeight = parseFloat(row.cells[8].childNodes[0].value);
      eeHours = parseFloat(row.cells[10].childNodes[0].value);
//      coversCnt=coversCnt + (parseFloat(eeCovers) * eeWeight);
      coversCnt=coversCnt + eeCovers;
      tot = 0  + parseFloat(row.cells[9].childNodes[0].value);
      setupAmt = parseFloat(row.cells[11].childNodes[0].value);
      clearAmt = parseFloat(row.cells[12].childNodes[0].value);   //setupAmt = getSetupAmt(row);
      extraAmt = parseFloat(row.cells[13].childNodes[0].value);

//      if (rowCnt > 7 && rowCnt < 13) {
//         alert("Cnt:" + rowCnt + "  Row:"+ row.cells[0].innerHTML +"  Emp:" + row.cells[2].innerHTML + "  Calc:" + compMethod + "  Covs:" + eeCovers + "  grat1:" + foodGrat + " gratRate:" + grat1CutRate + " ");
//      }

      cut1 = 0;
      if (grat1 != "X") {
         compMethod = get_calc_method(funcType, eeType, grat1);
//         alert("Func:" + funcType + " eeType:"+ eeType +" grat:"+ grat1 + " meth:"+ compMethod);
         if (compMethod == "1") {
            cut1 = calc1(grat1Group, grat1Amt, grat1CutRate);
            cut1 = Math.round(cut1 * eeWeight * 100) / 100;
         }
         if (compMethod == "2") {
            cut1 = calc2(totCovers, eeCovers, grat1Amt, grat1CutRate);
            cut1 = Math.round(cut1 * 100) / 100;
         }
         if (compMethod == "4") {
            cut1 = parseFloat(row.cells[14].childNodes[0].value);
            if (cut1 == "undefined")
                cut1 = 0;
            row.cells[14].childNodes[0].removeAttribute('readonly','readonly');
         }
         if (compMethod == "5") {
            cut1 = calc5(grat1Group, eeHours, grat1Amt, grat1CutRate, i);
            cut1 = Math.round(cut1 * eeWeight * 100) / 100;
         }
      }
      row.cells[14].childNodes[0].value = cut1;

      cut2 = 0;
      if (grat2 != "X") {
         compMethod = get_calc_method(funcType, eeType, grat2);
         if (compMethod == "1") {
            cut2 = calc1(grat2Group, grat2Amt, grat2CutRate);
            cut2 = Math.round(cut2 * eeWeight * 100) / 100;
         }
         if (compMethod == "2") {
            cut2 = calc2(totCovers, eeCovers, grat2Amt, grat2CutRate);
            cut2 = Math.round(cut2 * 100) / 100;
         }
         if (compMethod == "4") {
            cut2 = parseFloat(row.cells[15].childNodes[0].value);
            if (cut2 == "undefined")
                cut2 = 0;
            row.cells[15].childNodes[0].removeAttribute('readonly','readonly');
         }
         if (compMethod == "5") {
            cut2 = calc5(grat2Group, eeHours, grat2Amt, grat2CutRate);
            cut2 = Math.round(cut2 * eeWeight * 100) / 100;
         }
      }
      row.cells[15].childNodes[0].value = cut2;

      cut3 = 0;
      if (grat3 != "X") {
         compMethod = get_calc_method(funcType, eeType, grat3);
         if (compMethod == "1") {
            cut3 = calc1(grat3Group, grat3Amt, grat3CutRate);
            cut3 = Math.round(cut3 * eeWeight * 100) / 100;
         }
         if (compMethod == "2") {
            cut3 = calc2(totCovers, eeCovers, grat3Amt, grat3CutRate);
            cut3 = Math.round(cut3 * 100) / 100;
         }
         if (compMethod == "4") {
            cut3 = parseFloat(row.cells[16].childNodes[0].value);
            if (cut3 == "undefined")
                cut3 = 0;
            row.cells[16].childNodes[0].removeAttribute('readonly','readonly');
         }
         if (compMethod == "5") {
            cut3 = calc5(grat3Group, eeHours, grat3Amt, grat3CutRate);
            cut3 = Math.round(cut3 * eeWeight * 100) / 100;
         }
      }
      row.cells[16].childNodes[0].value = cut3;

      tot      = Math.round((parseFloat(tot) + cut1) * 100) / 100;
      tot      = Math.round((parseFloat(tot) + cut2) * 100) / 100;
      tot      = Math.round((parseFloat(tot) + cut3) * 100) / 100;
      cut1Grand = Math.round((cut1Grand + cut1) * 100) / 100;
      cut2Grand = Math.round((cut2Grand + cut2) * 100) / 100;
      cut3Grand = Math.round((cut3Grand + cut3) * 100) / 100;
      if (setupAmt > 0)
         tot = Math.round((tot + setupAmt) * 100) / 100;
      if (clearAmt > 0)
         tot = Math.round((tot + clearAmt) * 100) / 100;
      if (extraAmt > 0)
         tot = Math.round((tot + extraAmt) * 100) / 100;
      row.cells[17].childNodes[0].value = tot;
      rowCnt++;
   }
//   document.getElementById('foodTotal').innerHTML = foodGrand;
//   document.getElementById('barTotal').innerHTML  = barGrand;
   gridTots();
//   alert("Calced on " + rowCnt + " rows.");
//   alert("food net: "  + foodNetCnt + " bar: " + grat2NetCnt);
   if (grat1NetCnt == 1) {
      loopGrid(netGrat1);
   } else {
      if (grat1NetCnt > 1) {
          popup("Warning: More than 1 payee is a Net Food Account, no Net allocated.", "OK", okButt);
      }
   }
   if (grat2NetCnt == 1) {
      loopGrid(netGrat2);
   } else {
      if (grat2NetCnt > 1) {
          popup("Warning: More than 1 payee is a Net Bar Account, no Net allocated.", "OK", okButt);
      }
   }
   if (grat3NetCnt == 1) {
      loopGrid(netGrat3);
   } else {
      if (grat3NetCnt > 1) {
          popup("Warning: More than 1 payee is a Net Bar Account, no Net allocated.", "OK", okButt);
      }
   }
   var cut1Diff = Math.round((cut1Grand - grat1Amt) * 100) / 100;
   var cut2Diff = Math.round((cut2Grand - grat2Amt) * 100) / 100;
   var cut3Diff = Math.round((cut3Grand - grat3Amt) * 100) / 100;
   if (cut1Diff > 5 && grat1Amt != 0) {
       popup("Warning: Gratuity 1 disbursement is $" +cut1Diff+ " over.", "OK", okButt);
   }
   if (cut2Diff > 5 && grat2Amt != 0) {
       popup("Warning: Gratuity 2 disbursement is $" +cut2Diff+ " over.", "OK", okButt);
   }
   if (cut3Diff > 5 && grat3Amt != 0) {
       popup("Warning: Gratuity 3 disbursement is $" +cut3Diff+ " over.", "OK", okButt);
   }

   if (coversCnt > totCovers) {
       popup("Warning: Total number of covers (" +coversCnt+ ") exceeds Total Covers (" +totCovers+ ").", "OK", okButt);
   }

   edit_bodies("gt");
}

function loopGrid2() {
   var empGrid = document.getElementById('empGridBody');    //Get the table tag that holds the list of employees
   var eeWeight, nameType, eeTypeDescr, grat1Group, grat2Group, grat3Group, fnd="N", empCnts={}, empCnts2={}, grdFld;
   for (var i = 0, row; row = empGrid.rows[i]; i++) {
      eeWeight = parseFloat(row.cells[8].childNodes[0].value);
      grdFld=document.getElementById("eeType"+row.cells[1].innerHTML);
      eeTypeDescr = getOption(grdFld, grdFld.value, "etd");
      //row.cells[3].innerHTML;
      grat1Group  = row.cells[4].getAttribute("group");
      grat2Group  = row.cells[5].getAttribute("group");
      grat3Group  = row.cells[6].getAttribute("group");
//      if (empCnts.hasOwnProperty(eeTypeDescr)) {
//         empCnts[eeTypeDescr] = empCnts[eeTypeDescr] + eeWeight;
//         }
//      else {
//         empCnts[eeTypeDescr] = eeWeight;
//      }

//      alert("Count food group: " + grat1Group + " and bar group: " + barGroup + " for emp type: " + eeTypeDescr);
   // {Group :{Cnt: x, eeTypeDescr1: x1, eeTypeDescr2: x2, ... }}
      if (grat1Group != "") {
         if (empCnts2.hasOwnProperty(grat1Group)) {
            empCnts2[grat1Group]["Cnt"] = empCnts2[grat1Group].Cnt + eeWeight;
            }
         else {
            empCnts2[grat1Group] = {};
            empCnts2[grat1Group].Cnt = eeWeight;
         }
         if (empCnts2[grat1Group].hasOwnProperty(eeTypeDescr))
            empCnts2[grat1Group][eeTypeDescr] = empCnts2[grat1Group][eeTypeDescr] + eeWeight;
         else
            empCnts2[grat1Group][eeTypeDescr] = eeWeight;
      }
      if (grat2Group != grat1Group)
         if (grat2Group != "") {
            if (empCnts2.hasOwnProperty(grat2Group)) {
               empCnts2[grat2Group]["Cnt"] = empCnts2[grat2Group].Cnt + eeWeight;
               }
            else {
               empCnts2[grat2Group] = {};
               empCnts2[grat2Group].Cnt = eeWeight;
            }
            if (empCnts2[grat2Group].hasOwnProperty(eeTypeDescr))
               empCnts2[grat2Group][eeTypeDescr] = empCnts2[grat2Group][eeTypeDescr] + eeWeight;
            else
               empCnts2[grat2Group][eeTypeDescr] = eeWeight;
         }
      if (grat3Group != grat1Group && grat3Group != grat2Group)
         if (grat3Group != "") {
            if (empCnts2.hasOwnProperty(grat3Group)) {
               empCnts2[grat3Group]["Cnt"] = empCnts2[grat3Group].Cnt + eeWeight;
               }
            else {
               empCnts2[grat3Group] = {};
               empCnts2[grat3Group].Cnt = eeWeight;
            }
            if (empCnts2[grat3Group].hasOwnProperty(eeTypeDescr))
               empCnts2[grat3Group][eeTypeDescr] = empCnts2[grat3Group][eeTypeDescr] + eeWeight;
            else
               empCnts2[grat3Group][eeTypeDescr] = eeWeight;
         }
   }
   return empCnts2;
}

function eeGridSel(empRow) {
   var emplid = empRow.cells[1].innerHTML;
   chooseEe(document.getElementById(emplid));
}

function emplist_clear(empListRow) {
}

function loopGrid(func) {
   var empGrid = document.getElementById('empGridBody');    //Get the table tag that holds the list of employees
   for (var i = 0, row; row = empGrid.rows[i]; i++) {
      func(row);
   }
}

function insertGrid(rowNum) {
   var empGrid = document.getElementById('empGridTab');    //Get the table tag that holds the list of employees
   var lastRow = empGrid.rows.length;

   var fnd="N";
   for (var i = lastRow, row; i > lastRow; i++) {
      row = empGrid.rows[i];
      empCnt = row.cells[0].innerHTML;
      gridEmpId = row.cells[1].innerHTML;
      if (fnd =="Y") {
         row.cells[0].innerHTML = empCnt - 1;
      } else {
       	if (empId == gridEmpId) {
       	   fnd = "Y";
       	   empGrid.deleteRow(i);
           i--;
        }
      }
   }
}

function removeGrid(empId) {
   var empGrid = document.getElementById('empGridTab');    //Get the table tag that holds the list of employees
   var fnd="N";
   for (var i = 0, row; row = empGrid.rows[i]; i++) {
      empCnt = row.cells[0].innerHTML;
      gridEmpId = row.cells[1].innerHTML;
      if (fnd =="Y") {
         row.cells[0].innerHTML = empCnt - 1;
      } else {
       	if (empId == gridEmpId) {
       	   fnd = "Y";
       	   empGrid.deleteRow(i);
           i--;
        }
      }
   }
}

function chooseEe(empElm) {
  removeClass(empElm, 'notPicked');
  addClass(empElm, 'picked');
}

function unChooseEe(empElm) {
  removeClass(empElm, 'picked');
  addClass(empElm, 'notPicked');
}

function popeedata(empRow) {
   var empId=empRow.getAttribute('id');
   removeGrid(empId);
}

function removeEeType(empRow, eeTypeName) {
//  var nameType = empRow.html().split(':');
  var nameType = empRow.innerHTML.split(':');
  if (nameType[1] == " "+eeTypeName) {
//     empRow.addClass('notPicked');
//     empRow.removeClass('picked');
     popeedata(empRow);
     addClass(empRow, 'notPicked');
     removeClass(empRow, 'picked');
  }
}

function selectEeType(empRow, eeTypeName) {
//  var nameType = empRow.html().split(':');
  var nameType = empRow.innerHTML.split(':');
  if (nameType[1] == " "+eeTypeName) {
     addClass(empRow, 'picked');
     removeClass(empRow, 'notPicked');
     var eeObj=buildEeObj(empRow);
     addToGrid(eeObj);
  }
}

function loopEmpList(func, parm1) {
   var empList = document.getElementById('rightcol_empTab');    //Get the table tag that holds the list of employees
   for (var i = 0, row; row = empList.rows[i]; i++) {
       //iterate through rows
       //rows would be accessed using the "row" variable assigned in the for loop
       for (var j = 0, col; col = row.cells[j]; j++) {
//       	  doh = $("#"+col.id);
          doh = document.getElementById(col.id);
       	  func(doh, parm1);
       }
    }
}

function reset_eeTypes(eeTypeName){
   loopEmpList(removeEeType,eeTypeName);
}

function add_eeTypes(eeTypeName){
   reset_eeTypes(eeTypeName);
   loopEmpList(selectEeType,eeTypeName);
   calcGrid();
}

function add_eeTypes1(){
   reset_eeTypes('Captain');
   loopEmpList(selectEeType,'Captain');
   reset_eeTypes('House One');
   loopEmpList(selectEeType,'House One');
   calcGrid();
}

// Update the employee counts displayed on the screen
function updateEmpCnts() {
  var empCounts=document.getElementById('empCounts');
  removeKids(empCounts);
  var newUl = document.createElement("ul"), newUl2, newLi;
  newLi = document.createElement("li");

  var newInp, newrow, newcell, typeCnt=0, first, empCnts=loopGrid2();

  for(var propt in empCnts){
     newLi = document.createElement("li");
     newLi.id="empCnt" + propt;
//     newLi.setAttribute("class","empGroup");
     addClass(newLi,"empGroup");
     newLi.innerHTML="" + propt+': ' + empCnts[propt].Cnt;
     newUl.appendChild(newLi);
     typeCnt++;

     first=0;
//     if (Object.keys(empCnts[propt]).length > 2) {
     if (object_keys(empCnts[propt]).length > 2) {
//alert(Object.keys(empCnts[propt]).length);
        newUl2 = document.createElement("ul")
        for(var propt2 in empCnts[propt]){
//           alert(propt2 + " has " + empCnts[propt][propt2]);
           if (first !=0) {
              newLi = document.createElement("li");
              newLi.id="empType" + propt2;
//              newLi.setAttribute("class","empGrpType");
              addClass(newLi,"empGroup");
              newLi.innerHTML=" -" + propt2+': ' + empCnts[propt][propt2];
              typeCnt++;
              newUl2.appendChild(newLi);
           }
           first++;
           }
        newUl.appendChild(newUl2);
        }
     }
  empCounts.appendChild(newUl);
}

// Update the employee counts displayed on the screen
function updateEmpCnts2() {
  var cntsTab=document.getElementById('tabEmpCnts');
  for (var i = cntsTab.rows.length - 1; i > -1; i--) {
     cntsTab.deleteRow(i);
   }

  var newInp, newrow, newcell, typeCnt=0, first, empCnts=loopGrid2();
//  for(var propt in empCnts){
//    alert('<'+propt + '>: ' + empCnts[propt]);
//     newrow=cntsTab.insertRow(typeCnt);
//     newcell=newrow.insertCell(0);
//     newcell.id="empCnt" + propt;
//     newcell.innerHTML="" + propt+': ' + empCnts[propt];

//     newcell=newrow.insertCell(1);
//     typeCnt++;
//     }
  for(var propt in empCnts){
//     alert('<'+propt + '>: ' + empCnts[propt]);
     newrow=cntsTab.insertRow(typeCnt);
     newcell=newrow.insertCell(0);
     newcell.id="empCnt" + propt;
//     newcell.setAttribute("class","empGroup");
     addClass(newcell,"empGroup");
     newcell.innerHTML="" + propt+': ' + empCnts[propt].Cnt;
     typeCnt++;

     first=0;
//     if (Object.keys(empCnts[propt]).length > 2)
     if (object_keys(empCnts[propt]).length > 2)
//alert(Object.keys(empCnts[propt]).length);
     for(var propt2 in empCnts[propt]){
//        alert(propt2 + " has " + empCnts[propt][propt2]);
        if (first !=0) {
           newrow=cntsTab.insertRow(typeCnt);
           newcell=newrow.insertCell(0);
           newcell.id="empType" + propt2;
//           newcell.setAttribute("class","empGrpType");
           addClass(newcell,"empGrpType");
           newcell.innerHTML=" -" + propt2+': ' + empCnts[propt][propt2];
           typeCnt++;
        }
        first++;
        }
     }
}

function setGridRow(empObj, rowNum) {
  var emplid, baseWage, chld, chld2, json, isFoodNet, isBarNet;
  var empGrid = document.getElementById('empGridBody');    //Get the table tag that holds the list of employees
   var grat1 = document.getElementById('grat1').value;
   var grat2 = document.getElementById('grat2').value;
   var grat3 = document.getElementById('grat3').value;

  var thisRowNum, nextRow = empGrid.rows.length;

  var newrow = empGrid.rows[rowNum];
  addEvent(newrow, "change", total_grid_row);
  removeKids(newrow);

  var cutFlags;
  
  get_grat_types(empObj);

  var newcell=newrow.insertCell(0);
  thisRowNum = parseFloat(rowNum) + 1;  // - 1;  //minus 1 for header
  newcell.innerHTML="" + thisRowNum;
  addClass(newcell,"w1");

  newcell=newrow.insertCell(1);
  newcell.innerHTML=empObj["emplid"];
  newcell.setAttribute("id", "grid"+empObj["emplid"]);
  //                                       0                        1                        2                           3                          4                         5                          6                              7                                8
  newcell.setAttribute("name",""+empObj["eeType"] + ":" + empObj["payGrp"] + ":" + empObj["emplClass"] + ":" + empObj["getSetup"] + ":" + empObj["getClear"] + ":" + empObj["getExtra"] + ":" + empObj["eeBaseWage"] + ":" + empObj["coversAllowed"]);
//  newcell.setAttribute("name",""+empObj["eeType"] + ":" + empObj["payGrp"] + ":" + empObj["emplClass"] + ":" + empObj["getSetup"] + ":" + empObj["getClear"] + ":" + empObj["getExtra"] + ":" + empObj["eeBaseWage"] + ":" + empObj["coversAllowed"] + ":" + empObj["compMethod"]);
  addClass(newcell,"w2");

//  var nameType = empElm.html().split(':');

  newcell=newrow.insertCell(2);
  newcell.innerHTML=empObj["name"];
  addEvent(newcell, 'contextmenu', function (e){stop_prop(e); addClassEvent(e,"selected"); disp_listbox(e); return false;});
  addClass(newcell,"w3");

  newcell=newrow.insertCell(3);
  chld=document.createElement("select");
  chld.setAttribute("id","eeType"+empObj["emplid"]);
//  chld.setAttribute("type","text");   not needed, bombs IE
  chld.setAttribute("value",empObj["eeType"]);
  json =  eval('(' +document.getElementById("empTypeOpts").innerHTML+ ')');
  for (var eeType in json) {
  	chld2=document.createElement("option");
  	chld2.setAttribute("value",eeType);
  	chld2.innerHTML=json[eeType]["eeTypeDescr"];
  	chld2.setAttribute("etd",json[eeType]["eeTypeDescr"]);
  	if (empObj["eeType"] == eeType) {
  	   chld2.setAttribute("selected","selected");
  	   isFoodNet = json[eeType]["foodNet"];
  	   isBarNet  = json[eeType]["barNet"];
//  	   alert("nets are: " +isFoodNet+ " and " + isBarNet);
  	}
  	chld.appendChild(chld2);
  }
  addEvent(chld, "change", updEeDets);
  newcell.appendChild(chld);
  addClass(newcell,"w4");
//  newcell.innerHTML=empObj["eeTypeDescr"];

  newcell=newrow.insertCell(4);     //food rate    - Gratuity 1
  addClass(newcell,"w4");
  if (typeof empObj["grat1"] != "undefined") {
     newcell.innerHTML=empObj["grat1"]["gratDescr"];
     newcell.setAttribute("gratType",empObj["grat1"]["gratType"]);
     newcell.setAttribute("group",empObj["grat1"]["groupType"]);
     newcell.setAttribute("cutRate",empObj["grat1"]["cutRate"]);
     if (empObj["grat1"]["netAcct"] == "Y") {
        addClass(newcell,"netAcct");
        newcell.setAttribute("title","This is a net account.");
     }
  } else {
    newcell.setAttribute("group","");
    newcell.setAttribute("cutRate","0");
  }
  if (grat1 == "X")
     addClass(newcell,"hidecell");     

  newcell=newrow.insertCell(5);     //bar rate      - Gratuity 2
  addClass(newcell,"w4");
  if (typeof empObj["grat2"] != "undefined") {
    newcell.innerHTML=empObj["grat2"]["gratDescr"];
    newcell.setAttribute("gratType",empObj["grat2"]["gratType"]);
    newcell.setAttribute("group",empObj["grat2"]["groupType"]);
    newcell.setAttribute("cutRate",empObj["grat2"]["cutRate"]);
    if (empObj["grat2"]["netAcct"] == "Y") {
       addClass(newcell,"netAcct");
       newcell.setAttribute("title","This is a net account.");
    }
  } else {
    newcell.setAttribute("group","");
    newcell.setAttribute("cutRate","0");
  }
  if (grat2 == "X")
     addClass(newcell,"hidecell");     

  newcell=newrow.insertCell(6);              // Gratuity 3
  addClass(newcell,"w4");
  if (typeof empObj["grat3"] != "undefined") {
    newcell.innerHTML=empObj["grat3"]["gratDescr"];
    newcell.setAttribute("gratType",empObj["grat3"]["gratType"]);
    newcell.setAttribute("group",empObj["grat3"]["groupType"]);
    newcell.setAttribute("cutRate",empObj["grat3"]["cutRate"]);
    if (empObj["grat3"]["netAcct"] == "Y") {
       addClass(newcell,"netAcct");
       newcell.setAttribute("title","This is a net account.");
    }
  } else {
    newcell.setAttribute("group","");
    newcell.setAttribute("cutRate","0");
  }
  if (grat3 == "X")
     addClass(newcell,"hidecell");     

  newcell=newrow.insertCell(7);
  if (empObj["coversAllowed"] == "Y") {
     newcell.innerHTML=newcell.innerHTML='<input type="text" class="numfld" id = "bw'+ empObj["emplid"] + '" size="3" value="' +empObj["eeCovers"]+ '"/>';
  } else {
     newcell.innerHTML=newcell.innerHTML='<input type="text" class="numfld" id = "bw'+ empObj["emplid"] + '" size="3" value="0"/>';
  }
  addEvent(newcell.childNodes[0], 'blur', calcGrid);
  addClass(newcell,"w5");

  newcell=newrow.insertCell(8);
  newcell.innerHTML=newcell.innerHTML='<input type="text" class="numfld" id = "ew'+ empObj["emplid"] + '" size="3" value="' +empObj["eeWeight"]+ '"/>';
  addEvent(newcell.childNodes[0], 'blur', calcGrid);
  addEvent(newcell.childNodes[0], 'change', updateEmpCnts);
  addClass(newcell,"w5");

  newcell=newrow.insertCell(9);     //Base Wage
  if (empObj["eeBaseWage"] == "Y") {
    newcell.innerHTML='<input type="text" class="numfld" id = "bw'+ empObj["emplid"] + '" size="5" value="'+empObj["baseWage"]+'"/>';
    addEvent(newcell.childNodes[0], 'blur', calcGrid);
  } else {
     newcell.innerHTML='<input type="text" class="numfld" id = "bw'+ empObj["emplid"] + '" size="5" value="0" readonly/>';
     newcell.id="bw" +thisRowNum;
  }
  addClass(newcell,"w6");
  addEvent(newcell.childNodes[0],'change',set_zero);

  newcell=newrow.insertCell(10);     //Default Hours
  newcell.innerHTML='<input type="text" class="numfld" size="4" value="'+empObj["hours"] + '"/>';
  addClass(newcell,"w5");
  addEvent(newcell.childNodes[0],'change',hours_changed);

  newcell=newrow.insertCell(11);     //Default Setup
  if (empObj["getSetup"] == "Y") {
     newcell.innerHTML='<input type="text" class="numfld" id = "ds'+ empObj["emplid"] + '" size="4"  value="'+empObj["setupAmt"] + '"/>';
     addEvent(newcell.childNodes[0], 'blur', calcGrid);
  }   else
     newcell.innerHTML='<input type="text" class="numfld" size="4"  value="0"/>';
  addClass(newcell,"w5");
  addEvent(newcell.childNodes[0],'change',set_zero);

  newcell=newrow.insertCell(12);     //Default Clear
  if (empObj["getClear"] == "Y") {
     newcell.innerHTML='<input type="text" class="numfld" id = "dc'+ empObj["emplid"] + '" size="4" value="'+empObj["clearAmt"] + '"/>';
     addEvent(newcell.childNodes[0], 'blur', calcGrid);
  }   else
     newcell.innerHTML='<input type="text" class="numfld" size="4" value="0"/>';
  addClass(newcell,"w5");
  addEvent(newcell.childNodes[0],'change',set_zero);

  newcell=newrow.insertCell(13);    //Default Extra
  if (empObj["getExtra"] == "Y") {
     newcell.innerHTML='<input type="text" class="numfld" id = "de' + empObj["emplid"] + '" size="4" value="'+empObj["extraAmt"] + '"/>';
     addEvent(newcell.childNodes[0], 'blur', calcGrid);
  }   else
     newcell.innerHTML='<input type="text" class="numfld" size="4" value="0"/>';
  addClass(newcell,"w5");
  addEvent(newcell.childNodes[0],'change',set_zero);

  newcell=newrow.insertCell(14);    //"Food" Cut
  if (grat1 == "X")
     addClass(newcell,"hidecell");     
  newcell.innerHTML='<input type="text" class="numfld" size="7" value=' +empObj["grat1Cut"] +' readonly/>';
  addClass(newcell,"w6");

  newcell=newrow.insertCell(15);    //"Bar" Cut
  if (grat2 == "X")
     addClass(newcell,"hidecell");     
  newcell.innerHTML='<input type="text" class="numfld" size="7" value=' +empObj["grat2Cut"] +' readonly/>';
  addClass(newcell,"w6");

  newcell=newrow.insertCell(16);    //"Wine" Cut
  if (grat3 == "X")
     addClass(newcell,"hidecell");     
  newcell.innerHTML='<input type="text" class="numfld" size="7" value=' +empObj["grat3Cut"] +' readonly/>';
  addClass(newcell,"w6");

  newcell=newrow.insertCell(17);    //Total Pay
  newcell.innerHTML='<input type="text" class="numfld" size="7" value=' +empObj["totalPay"] +' readonly/>';
  addClass(newcell,"w6");

  updateEmpCnts();  ///???
//  calcGrid();  this is too often
}

function addToGrid(eeObj) {
  var empGrid     = document.getElementById('empGridTab');
  var empGridBody = document.getElementById('empGridBody');
  var nextRow     = empGrid.rows.length;                  //Get length which is same as next insert row #
  var nextRowBody = empGridBody.rows.length;              //Get length which is same as next insert row #
//  alert("Insert " + nextRow + ":: " + nextRowBody);

  var newrow=empGridBody.insertRow(nextRowBody);
  newrow.setAttribute("class","gridBodyRow");

  setGridRow(eeObj, nextRowBody);
}

function replace_in_grid(eeObj, rownum) {
  setGridRow(eeObj, rownum);
}

//  Populate the employee object (as used on the grid) with default employee type data stored in the hidden2 data area
function getEeTypeDets(eeObj) {
   var eeDetsJson = eval('(' +document.getElementById("empTypeOpts").innerHTML+ ')');
   var eeDets = eeDetsJson[eeObj["eeType"]];
//   for (var g in eeDets)
//      alert(g + " is " + eeDets[g]);
//   eeObj["emplClass"]=eeDets["emplClass"];    this comes from EE
   eeObj["getSetup"]=eeDets["getSetup"];
   eeObj["getClear"]=eeDets["getClear"];
   eeObj["getExtra"]=eeDets["getExtra"];

//   eeObj["foodRate"]=eeDets["foodTipPercent"];
//   eeObj["foodGroup"]=eeDets["foodGroup"];
//   eeObj["barRate"]=eeDets["barTipPercent"];
//   eeObj["barGroup"]=eeDets["barGroup"];

   eeObj["coversAllowed"]=eeDets["coversAllowed"];
   eeObj["eeBaseWage"]=eeDets["eeBaseWage"];
   if (eeObj["emplClass"] && eeObj["payGrp"]){
      eeObj["baseWage"] = get_baseWage(eeObj["emplClass"], eeObj["payGrp"]);
    }
   else
      eeObj["baseWage"] = 0;
//   if (document.getElementById("empClass"+eeObj["emplClass"]))
//      eeObj["baseWage"] = document.getElementById("empClass"+eeObj["emplClass"]).innerHTML;
//   else
//      eeObj["baseWage"]=0;
   if (eeObj["payGrp"] == "26")
      eeObj["hours"]=eeDets["defHours"];
   else
      eeObj["hours"]=0;
   eeObj["compMethod"]=eeDets["compMethod"];
   if (eeObj["coversAllowed"] == "Y")
      eeObj["eeCovers"] = document.getElementById('defCovers').innerHTML;
   else
      eeObj["eeCovers"] = 0;

   get_grat_types(eeObj);  //Is this done elsewhere?
}

// This event fires when the employee role is change in the grid.  Must update things like base wage, rates and covers.
function updEeDets(e) {
   e = e || window.event;
   if (e.target) var targ = e.target;
   else if (e.srcElement) var targ = e.srcElement;

   var elm=targ;
   var re=/^eeType(\w+)/g;
   var str = elm.id;
//   var matches=str.match(re);
   var matches=re.exec(str);
//   alert("Matched len: " + matches.length);
   emplid = matches[1];
//   alert("match 0: " + matches[0]);
//   alert("match 1: " + matches[1]);
   var currIdx = elm.parentNode.parentNode.rowIndex - 1;
 //  alert("Change at row " + currIdx);
   var currRow2 = document.getElementById("empGridBody").rows[currIdx];
//   alert("Change Role at: " + currRow.cells[0].innerHTML + " or is it " + currRow2.cells[0].innerHTML);
   var eeObj= buildEeObjGrid(currRow2, elm.value);
   eeObj["eeType"]=elm.value;
//   alert("Change to EE Type: " + elm.value);
   getEeTypeDets(eeObj)
//   for (var g in eeObj)
//      alert(g + " is " + eeObj[g]);
//    document.getElementById("empGridTab").deleteRow(currIdx);
    replace_in_grid(eeObj, currIdx);
//    setGridRow(eeObj, currIdx);
    updateEmpCnts();
    calcGrid();
}

//Given a Gratuity Type, this function returns the "row" that it is used on the form.  This is for assigning sequence, particularly at save time so that they reload in the same order.
function get_grat_num(gratType) {
   var gratOpt, gratGrid = document.getElementById("gratsGrid");
   for (i=0; i<3; i++) {
      gratOpt = gratGrid.rows[i].cells[0].childNodes[0].value;   //F B W
      if (gratOpt == gratType)
         return i + 1;
   }
   return 0;
}

// This function takes an Obj and adds to it the Gratuity details from the function form based on the EE Type in the passed object.
// This is used during the saving of the form, and in building EE Objects for the grid.   Will set critical information used in the Calc routine and employee counting procedures
// {"grat1",{"gratType":"F","groupType":"Captains","cutRate":"20.413","netAcct":"N","gratDescr":"Food"},"grat2",{...
// If the same grat type is used on 2 different rows, only the first is returned.
function get_grat_types(eeObj, gratNum)  {
   var gratTypeObj = eval('(' +document.getElementById("gratTypes").innerHTML+ ')');
   delete eeObj["grat1"];
   delete eeObj["grat2"];
   delete eeObj["grat3"];
   var eeType = eeObj["eeType"];
   var eeGrat, gratCnt, gratOpt, gratId;
   for (var gratRow in gratTypeObj) {
      if (gratTypeObj[gratRow]["eeType"] == eeType) {
      	eeGrat = {};
      	eeGrat["gratType"]  = gratTypeObj[gratRow]["gratType"];
      	eeGrat["groupType"] = gratTypeObj[gratRow]["groupType"];
      	eeGrat["cutRate"]   = gratTypeObj[gratRow]["cutRate"];
      	eeGrat["netAcct"]   = gratTypeObj[gratRow]["netAcct"];
      	eeGrat["gratDescr"] = gratTypeObj[gratRow]["gratDescr"];

        gratCnt = get_grat_num(eeGrat["gratType"]);
        gratId = "grat" + gratCnt;
        if (gratCnt != 0)                            //do not include if not in the grats grid
           eeObj[gratId] = eeGrat;
      }
   }
}

function get_grat_dets(eeObj, gratType, gratNum)  {
   var gratTypeObj = eval('(' +document.getElementById("gratTypes").innerHTML+ ')');
   delete eeObj["grat1"];
   delete eeObj["grat2"];
   delete eeObj["grat3"];
   var eeType = eeObj["eeType"];
   var eeGrat, gratCnt, gratOpt, gratId;
   for (var gratRow in gratTypeObj) {
      if (gratTypeObj[gratRow]["eeType"] == eeType) {
      	eeGrat = {};
      	if (gratTypeObj[gratRow]["gratType"] == gratType) {
      	   eeGrat["gratType"]  = gratTypeObj[gratRow]["gratType"];
      	   eeGrat["groupType"] = gratTypeObj[gratRow]["groupType"];
      	   eeGrat["cutRate"]   = gratTypeObj[gratRow]["cutRate"];
      	   eeGrat["netAcct"]   = gratTypeObj[gratRow]["netAcct"];
      	   eeGrat["gratDescr"] = gratTypeObj[gratRow]["gratDescr"];
           eeObj[gratNum] = eeGrat;
        }
      }
   }
}

// Build a JSON object for the employee grid for the employee from the employee list as passed in the the id reference.
function buildEeObj(idEmplid) {
   var eeObj = {}, cutFlags;
   var defSetup = document.getElementById('defSetup').value;
   var defClear = document.getElementById('defClear').value;
   var defExtra = document.getElementById('defExtra').value;

   eeObj["unitId"]=document.getElementById("unitId").innerHTML.split(" ")[1];
   eeObj["eventNum"]=document.getElementById("eventNum").innerHTML;
   eeObj["empSeq"]=0;
   eeObj["emplid"]=idEmplid.getAttribute("empid");
   eeObj["name"]=idEmplid.innerHTML.split(":")[0];
   eeObj["eeType"]=idEmplid.getAttribute("name").split(":")[0];

   get_grat_types(eeObj);

   eeObj["payGrp"]=idEmplid.getAttribute("name").split(":")[1];
   eeObj["emplClass"]=idEmplid.getAttribute("name").split(":")[2];
   getEeTypeDets(eeObj);
   eeObj["eeCovers"]=document.getElementById('defCovers').innerHTML;
   eeObj["eeWeight"]=1;
   if (eeObj["getSetup"] == "Y") {
     eeObj["setupAmt"]=defSetup;
   } else {
     eeObj["setupAmt"]=0;
   }
   if (eeObj["getClear"] == "Y") {
     eeObj["clearAmt"]=defClear;
   } else {
     eeObj["clearAmt"]=0;
   }
   if (eeObj["getExtra"] == "Y") {
     eeObj["extraAmt"]=defExtra;
   } else {
     eeObj["extraAmt"]=0;
   }
   eeObj["grat1Cut"]=0;
   eeObj["grat2Cut"]=0;
   eeObj["grat3Cut"]=0;
   eeObj["totalPay"]=0;
   return eeObj;
}

// Build a JSON object for the employee grid for the employee from the grid as passed in the the row reference.
function buildEeObjGrid(gridRow, eeTypeOverride) {
   var eeObj = {}, cutFlags, anAmt;

   eeObj["unitId"]=document.getElementById("unitId").innerHTML.split(":")[1];
   eeObj["eventNum"]=document.getElementById("eventNum").innerHTML;
   eeObj["empSeq"]=gridRow.cells[0].innerHTML;
   eeObj["emplid"]=gridRow.cells[1].innerHTML;
   eeObj["name"]=gridRow.cells[2].innerHTML;
   cutFlags=gridRow.cells[1].getAttribute("name").split(":");
   if (eeTypeOverride !== undefined) {
      eeObj["eeType"]=eeTypeOverride;
      getEeTypeDets(eeObj);
      }
   else {
      eeObj["getSetup"]=cutFlags[3];
      eeObj["getClear"]=cutFlags[4];
      eeObj["getExtra"]=cutFlags[5];
      eeObj["eeType"]=cutFlags[0];
      }
   eeObj["payGrp"]=cutFlags[1];
   eeObj["emplClass"]=cutFlags[2];
   eeObj["eeBaseWage"]=cutFlags[6];
   eeObj["coversAllowed"]=cutFlags[7];
   eeObj["compMethod"]=cutFlags[8];

   get_grat_types(eeObj);

//   eeObj["eeTypeDescr"]=idEmplid.innerHTML.split(":")[1];

//   eeObj["foodRate"]=gridRow.cells[4].innerHTML;
//   eeObj["foodGroup"]=gridRow.cells[4].getAttribute("group");
//   eeObj["barRate"]=gridRow.cells[5].innerHTML;
//   eeObj["barGroup"]=gridRow.cells[5].getAttribute("group");

   eeObj["eeCovers"]=gridRow.cells[7].childNodes[0].value;
   eeObj["eeWeight"]=gridRow.cells[8].childNodes[0].value;
   eeObj["baseWage"]=gridRow.cells[9].childNodes[0].value;
   eeObj["hours"]=gridRow.cells[10].childNodes[0].value;

   var anAmt = gridRow.cells[11].childNodes[0].value;
   if (eeObj["getSetup"] == "Y") {
     eeObj["setupAmt"]= document.getElementById('defSetup').value;
   } else {
     eeObj["setupAmt"]=0;
   }
   if (eeObj["getClear"] == "Y") {
     eeObj["clearAmt"]=document.getElementById('defClear').value;
   } else {
     eeObj["clearAmt"]=0;
   }
   if (eeObj["getExtra"] == "Y") {
     eeObj["extraAmt"]=document.getElementById('defExtra').value;
   } else {
     eeObj["extraAmt"]=0;
   }
   eeObj["grat1Cut"]=gridRow.cells[14].childNodes[0].value;
   eeObj["grat2Cut"]=gridRow.cells[15].childNodes[0].value;
   eeObj["grat3Cut"]=gridRow.cells[16].childNodes[0].value;
   eeObj["totalPay"]=gridRow.cells[17].childNodes[0].value;
   return eeObj;
}

function findEE(emplid) {
  var empList=document.getElementById('rightcol_empTab');
  for (var i = 0, row; row = empList.rows[i]; i++) {
     if (row.cells[0].id == emplid) {
     	return row;  //alert("Found emp at " + i);
     }
  }
  return null;
}

function selectee(e){
// get the form field that fired this event
   e = e || window.event;
   if (e.target) var targ = e.target;
   else if (e.srcElement) var targ = e.srcElement;

//  var elm = $(event.target);  // getEventSrc(event);
// This is the field that holds the base of the weblib call.  Only addition thing need is to tack on the arguement (fieldname).
   var empGrid = document.getElementById('empGridTab');    //Get the table tag that holds the list of employees
//   var fldName = $(".multifld.picked");

  var fldVal = targ.getAttribute("id");
//  var fldDescr = escape($(event.target).html());

  var cutFlags, eeObj;
  var fldAct = 'select';
  if (hasClass(targ, 'picked')) {

  	unChooseEe(targ);   //event.target

  	var fnd="N";
  	for (var i = 0, row; row = empGrid.rows[i]; i++) {
  	    empCnt = row.cells[0].innerHTML;
  	    empId = row.cells[1].innerHTML;
  	    if (fnd =="Y") {
  	    	row.cells[0].innerHTML = empCnt - 1;
            } else {
         	if (empId == targ.getAttribute("id")) {     //elm.attr('id')) {
         	   fnd = "Y";
         	   empGrid.deleteRow(i);
                   i--;
         	  }
	    }
        }
        updateEmpCnts();
        calcGrid();
        fldAct = 'remove';
  } else {
  	eeObj=buildEeObj(targ);  //event.target);

  	addToGrid(eeObj);
  	chooseEe(targ);  //event.target);

  	for (var p in eeObj) {
//  	   alert(p + ':' + eeObj[p]);
  	}
  	calcGrid();
  	scroll_to_bottom();
  }
  eventChanged();
//  var unicode=event.keyCode? event.keyCode : event.charCode;
}

//Event for when employee type button is clicked in right column.  Should call function to load sub set of employees and appropriate events
function loadEeList(e) {
   e = e || window.event;
   if (e.target) var targ = e.target;
   else if (e.srcElement) var targ = e.srcElement;

//   alert("Load " + targ.getAttribute("eeType"));
   var destDiv = targ.parentNode.parentNode.id;
   var listParms={"listId":"empListing", "listTab":"empList", "alphaId":"empAlphas", "buttId":"empListButts"};
   listParms["destDiv"] = destDiv;
   listParms["eeType"] = targ.getAttribute("eeType");

   extract_list(listParms);
}

function lettScroll(e) {
   e = e || window.event;
   if (e.target) var targ = e.target;
   else if (e.srcElement) var targ = e.srcElement;

   var theScroll = document.getElementById(targ.parentNode.getAttribute('listId'));
//   alert("Height: " + theScroll.scrollHeight+ " Client:" +theScroll.clientHeight + " / " + theScroll.scrollTop);
// The bigger the divisor, the further down the first name appears
//   theScroll.scrollTop=targ.getAttribute('letter') *  theScroll.clientHeight / 24.1; // / 289; // 22  * 23.4;	 //about 9 names
//   theScroll.scrollTop=targ.getAttribute('letter') *  theScroll.clientHeight / 25.8;  // / 24.1; // / 289; // 22  * 23.4;	 //about 9 names
   theScroll.scrollTop=parseInt(targ.getAttribute('letter')) * 23;  // / 24.1; // / 289; // 22  * 23.4;	 //about 9 names
}

function dump_elements(objParms){
  var dump="dump> ";
  for (var i in objParms) {
    dump += i + ":" + objParms[i] + "  ";
  }
  alert(dump);
}

function set_events2(objParms){
//   if (listObj) {}
//   else
//      $(".multiVal").click(function(event) {selectee(event); });
//   dump_elements(objParms);
   var destDivId = objParms["destDiv"];
   var destDiv = document.getElementById(destDivId);

   var empListDivId = destDivId + "_empList";
   var empListTblId = destDivId + "_empTab";
   var empAlphasId  = destDivId + "_empAlphas";

   var chld, jumpLetters = document.getElementById(empAlphasId);

   var childrenCnt = jumpLetters.childNodes.length;
   if (childrenCnt > 0) {
       for (var i = 0; i < childrenCnt; i++) {
       	 chldNode = jumpLetters.childNodes[i];
	       if (chldNode.getAttribute('letter'))
	           addEvent(chldNode, 'click', lettScroll);
       }
   }
   else
      return "0";

}

//  Populate the EE Grid from a saved function
function eeSummWeek(unitId, funcName) {
   var xmlHttpReq, json, newrow, newcell, emplid, formDiv, empData;
   clearForm();
   var formDiv=document.getElementById("todoform");
   var t = document.createElement('table');
   t.setAttribute("id", "listGrid");
   formDiv.appendChild(t);
//   eeSummHead(t);
   xmlHttpReq = get_xmlhttp();
   xmlHttpReq.onreadystatechange=function() {
   if (xmlHttpReq.readyState==4 && xmlHttpReq.status==200) {
//      var empGrid = document.getElementById("eeSummWeek");
//      var thisRowNum, nextRow = empGrid.rows.length;
      addClass(document.getElementById("todoform"),'listarea');
      var empList = eval('(' +xmlHttpReq.responseText+ ')');
      for (var empVal in empList) {
          json = empList[empVal];
          if (empVal == "1")
             eeSummHead2(json);
          else 
             setEeSumm(json);
          }
      }
   }
   xmlHttpReq.open("GET","jsonEmpSumm.php?unitId="+unitId,true);
   xmlHttpReq.send();
}

function eeSummHead2(headObj) {
//  var formDiv=document.getElementById("todoform");
//   removeKids(formDiv);
//  var outGrid = document.createElement('table');
//   outGrid.setAttribute("id", "listGrid");
//   formDiv.appendChild(outGrid);

  var outGrid = document.getElementById('listGrid');    //Get the table tag that holds the list of employees

  var newcell, newrow=outGrid.insertRow(0);
  var cellNum=0;
  for (var p in headObj) {
      newcell=newrow.insertCell(cellNum);
      addClass(newcell,"summhead");
      newcell.innerHTML=headObj[p];
      cellNum++;
  }
}

function setEeSumm(summObj) {
  var outGrid = document.getElementById('listGrid');    //Get the table tag that holds the list of employees

  var emplid, thisRowNum, nextRow = outGrid.rows.length;
  var newrow=outGrid.insertRow(nextRow);

  var newcell=newrow.insertCell(0);
  thisRowNum = outGrid.rows.length - 1;  //minus 1 for header
  newcell.innerHTML="" + thisRowNum;

  var cellNum=0;
  for (var p in summObj) {
//      alert(p + ':' + summObj[p]);
      if (p !="unitId" && p != "eeType") {
         cellNum++;
         newcell=newrow.insertCell(cellNum);
         if (p === "name") {
            var anch = document.createElement('a');
            anch.setAttribute("href","javascript:void(0);");
            anch.setAttribute("onclick","eeDetsWeek('" +summObj["emplid"]+ "','" +summObj["unitId"]+ "');");
            anch.innerHTML=summObj["name"];
            newcell.appendChild(anch);
         } else {
            if (summObj[p] == null)
               newcell.innerHTML="&nbsp;";
            else
               newcell.innerHTML=summObj[p];
            if (cellNum > 4) 
               addClass(newcell,"summfld");
         }
      }
  }
}

function eeDetsWeek(emplid, unitId) {
   var xmlhttp, json, newrow, newcell, formDiv, empData;
   formDiv=document.getElementById("todoform");
   var childrenCnt = formDiv.childNodes.length;
   if (childrenCnt > 0) {
       while (formDiv.hasChildNodes()){
	  formDiv.removeChild(formDiv.firstChild);
	}
    }
   xmlhttp = get_xmlhttp();
   xmlhttp.onreadystatechange=function() {
   if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      var empList = eval('(' +xmlhttp.responseText+ ')');
      var t = document.createElement('div');
      t.setAttribute("id", "listHeads");
      t.innerHTML=empList["1"]["emplid"] +":&nbsp"+ empList["1"]["name"];
      formDiv.appendChild(t);
      t = document.createElement('table');
      t.setAttribute("id", "listGrid");
      formDiv.appendChild(t);
      for (var empVal in empList) {
      	  json = empList[empVal];
          if (empVal == "1")
             eeDetsHead(json);
          else 
             setEeDets(json);
          }
      var retButt=document.createElement("img");
      retButt.setAttribute("src","./images/returnButton.gif");
      retButt.setAttribute("onclick","eeSummWeek('" +unitId+ "')");
      formDiv.appendChild(retButt);
      }
   }
   xmlhttp.open("GET","jsonEmpDetsWk.php?unitId="+unitId+"&emplid="+emplid,true);
   xmlhttp.send();
}

function eeDetsHead(headObj) {
  var formDiv=document.getElementById("todoform");
   removeKids(formDiv);
  var outGrid = document.createElement('table');
   outGrid.setAttribute("id", "listGrid");
   formDiv.appendChild(outGrid);

  var newrow=outGrid.insertRow(0);

  var newcell=newrow.insertCell(0);
  newcell.innerHTML="Row";
  addClass(newcell,"summhead");

  var newcell=newrow.insertCell(1);
  newcell.innerHTML=headObj["h1"];
  addClass(newcell,"summhead");
  
  var newcell=newrow.insertCell(2);
  newcell.innerHTML=headObj["h2"];
  addClass(newcell,"summhead");
  
  var newcell=newrow.insertCell(3);
  newcell.innerHTML=headObj["h3"];
  addClass(newcell,"summhead");
    
  var newcell=newrow.insertCell(4);
  newcell.innerHTML=headObj["h4"];
  addClass(newcell,"summhead");
    
  var newcell=newrow.insertCell(5);
  newcell.innerHTML=headObj["h5"];
  addClass(newcell,"summhead");
    
  var newcell=newrow.insertCell(6);
  newcell.innerHTML=headObj["h6"];
  addClass(newcell,"summhead");
    
  var newcell=newrow.insertCell(7);
  newcell.innerHTML=headObj["h7"];
  addClass(newcell,"summhead");
    
  var newcell=newrow.insertCell(8);
  newcell.innerHTML=headObj["h8"];
  addClass(newcell,"summhead");

  var newcell=newrow.insertCell(9);
  newcell.innerHTML=headObj["h9"];
  addClass(newcell,"summhead");

  var newcell=newrow.insertCell(10);
  newcell.innerHTML=headObj["h10"];
  addClass(newcell,"summhead");

  var newcell=newrow.insertCell(11);
  newcell.innerHTML=headObj["h11"];
  addClass(newcell,"summhead");

  var newcell=newrow.insertCell(12);
  newcell.innerHTML=headObj["h12"];
  addClass(newcell,"summhead");

  if (typeof headObj["h13"] != "undefined") {
     var newcell=newrow.insertCell(13);
     newcell.innerHTML=headObj["h13"];
     addClass(newcell,"summhead");
  }
  
  if (typeof headObj["h14"] != "undefined") {
     var newcell=newrow.insertCell(14);
     newcell.innerHTML=headObj["h14"];
     addClass(newcell,"summhead");
  }

  if (typeof headObj["h15"] != "undefined") {
     var newcell=newrow.insertCell(15);
     newcell.innerHTML=headObj["h15"];
     addClass(newcell,"summhead");
  }

  if (typeof headObj["h16"] != "undefined") {
     var newcell=newrow.insertCell(16);
     newcell.innerHTML=headObj["h16"];
     addClass(newcell,"summhead");
  }

  if (typeof headObj["h17"] != "undefined") {
     var newcell=newrow.insertCell(17);
     newcell.innerHTML=headObj["h17"];
     addClass(newcell,"summhead");
  }
}

function setEeDets(summObj) {
  var emplid, cellNum=0;
  var outGrid = document.getElementById('listGrid');    //Get the table tag that holds the list of employees

  var thisRowNum, nextRow = outGrid.rows.length;
  var newrow=outGrid.insertRow(nextRow);

  var newcell=newrow.insertCell(0);
  thisRowNum = outGrid.rows.length - 1;  //minus 1 for header
  newcell.innerHTML="" + thisRowNum;

//  newcell=newrow.insertCell(1);
//  newcell.innerHTML=summObj["emplid"];

//  newcell=newrow.insertCell(2);
//  newcell.innerHTML=summObj["name"];

  for (var p in summObj) {
//      alert(p + ':' + summObj[p]);
      if (p !="unitId" && p != "emplid" && p != "eeType") {
         cellNum++;
         newcell=newrow.insertCell(cellNum);
         newcell.innerHTML=summObj[p];
         if (cellNum > 3)
            addClass(newcell,"summfld");
      }
  }
}

function edit_function(unitId) {
  funcsWeek(unitId, loadFunc);
}

function delete_function(unitId) {
  funcsWeek(unitId, delete_func);
}
//
// Evaluate delete function results
//
function eval_del_func(json){
  var results = eval('(' +json+ ')');
  if (results["result"] =="true") {
    popup("Function was deleted.","OK", okButt);
    removeKids(document.getElementById("todoform"));
    }
  else
    popup("Function was not deleted.","OK", okButt);
}
//
// Call the php to delete function
//
function delete_the_function(unitId, eventNum) {
  var jsonText = '{"unitId":"' +unitId+ '","eventNum":"' +eventNum+ '"}';
  var json = eval('(' +jsonText+ ')');  
  ajax_post("deleteFunc.php", json, "todoform", eval_del_func);
}
//
// User clicks button on confirmation page to do the function deletion
//
function delete_confirm(e) {
  e = e || window.event;
  if (e.target) var targ = e.target;
  else if (e.srcElement) var targ = e.srcElement;

  popup("Are you sure you want to delete this function??", "Yes, Delete", function(){clear_pop(); delete_the_function(targ.getAttribute('unitid'), targ.getAttribute('func'));}, "No, Cancel", function(){clear_pop(); popup("Function is not deleted.","OK", okButt);});
}
//
// Set events on delete function confirmation page
//
function delete_func_events() {
  addEvent(document.getElementById("deleteButton"), "click", delete_confirm)
}
//
// User selects a function for deletion from the current week's list of functions
//
function delete_func(e) {
  e = e || window.event;
  if (e.target) var targ = e.target;
  else if (e.srcElement) var targ = e.srcElement;

  var jsonText = '{"unitId":"' +targ.getAttribute("unitid")+ '","eventNum":"' +targ.getAttribute("eventnum")+ '"}';
  var json = eval('(' +jsonText+ ')');
   
  xmlhttpPost4("deleteConfirm.php", json, "todoform", delete_func_events);   //, doFunc);
}

function funcsWeek(unitId, callBack) {
   var xmlhttp, json, newrow, newcell, emplid, formDiv, empData;
   formDiv=document.getElementById("todoform");
   removeKids(formDiv);
//   var childrenCnt = formDiv.childNodes.length;
//   if (childrenCnt > 0) {
//       while (formDiv.hasChildNodes()){
//	  formDiv.removeChild(formDiv.firstChild);
//	}
//    }
   var t = document.createElement('table');
   t.setAttribute("id", "listGrid");
   formDiv.appendChild(t);
   xmlhttp = get_xmlhttp();

   xmlhttp.onreadystatechange=function() {
   if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      removeClass(document.getElementById("todoform"),"listarea");
      removeClass(document.getElementById("todoform"),"formarea");
      addClass(document.getElementById("todoform"),"listarea");
      var empList = eval('(' +xmlhttp.responseText+ ')');
      for (var empVal in empList) {
      	  json = empList[empVal];
          if (empVal == "0")
             funcsHead(json);
          else
             setFuncs(json, callBack);
          }
      var retButt=document.createElement("img");
      retButt.setAttribute("src","./images/returnButton.gif");
      retButt.setAttribute("onclick","funcsWeek('" +unitId+ "')");
      formDiv.appendChild(retButt);
      }
   }
   xmlhttp.open("GET","jsonGetFuncsWk.php?unitId="+unitId,true);
   xmlhttp.send();
}

function funcsHead(summObj) {
  var outGrid = document.getElementById('listGrid');    //Get the table tag that holds the list of employees

  var newcell, newrow=outGrid.insertRow(0);
  var cellNum=0;
  for (var p in summObj) {
      newcell=newrow.insertCell(cellNum);
      addClass(newcell,"summhead");
      newcell.innerHTML=summObj[p];
      cellNum++;
  }
}

function setFuncs(summObj, callBack) {
  var emplid;
  var outGrid = document.getElementById('listGrid');    //Get the table tag that holds the list of employees

  var thisRowNum, nextRow = outGrid.rows.length;
  var newrow=outGrid.insertRow(nextRow);

  var newcell=newrow.insertCell(0);
  thisRowNum = outGrid.rows.length - 1;  //minus 1 for header
  newcell.innerHTML="" + thisRowNum;

  var cellNum=0;
  var unitId = summObj["unitId"];
  for (var p in summObj) {
//      alert(p + ':' + summObj[p]);
      if (p !="unitId" && p != "eventNum" && p != "wkendDate" && p != "roomNum" && p != "funcType") {
         cellNum++;
         newcell=newrow.insertCell(cellNum);
         if (p === "funcDate") {
            var anch = document.createElement('a');
            anch.setAttribute("href","javascript:void(0);");
            anch.setAttribute("unitid", summObj["unitId"]);
            anch.setAttribute("eventnum", summObj["eventNum"]);
            anch.setAttribute("title",  summObj["eventNum"]);
            anch.onclick = function(e){e = e || window.event; callBack(e); return false;};
            anch.innerHTML=summObj["funcDate"];
            newcell.appendChild(anch);
         } else {
            if (summObj[p] == null)
               newcell.innerHTML="&nbsp;";
            else
               newcell.innerHTML=summObj[p];
            if (cellNum > 4) 
               if (p === "messages")
                  addClass(newcell,"text");
               else
                  addClass(newcell,"summfld");
         }
      }
  }
}

// Report the function currently on screen
function func_report() {
   var unitId = document.getElementById('unitId').innerHTML.split(" ")[1];
   var eventNum = document.getElementById('eventNum').innerHTML;
   window.open("./repWeekFuncs.php?unitId="+unitId+"&eventNum="+eventNum);
}

function toggle_block(div_id) {
	var el = document.getElementById(div_id);
	if ( el.style.display == 'none' ) {	el.style.display = 'block';}
	else {el.style.display = 'none';}
}

function open_page() {
  var modal=document.getElementById("modal");
  modal.style.display='none';
  var popup_div=document.getElementById("popup_div");
  popup_div.style.display='none';
}

function clear_pop() {
	open_page();
	disp_popup.popList.shift();
	if (disp_popup.popList.length > 0)
	    disp_popup();
}

function grey_page() {
  var modal=document.getElementById("modal");
  modal.style.display='block';
}

function ungrey_page() {
  var modal=document.getElementById("modal");
  modal.style.display='none';
}

function disp_popup_box1() {
  var popDiv=document.getElementById("popup_div");   //Get the popup div
  removeKids(popDiv);
  popDiv.style.display='block';
}   

function pop_button1(e) {
  e = e || window.event;
  if (e.target) var targ = e.target;
  else if (e.srcElement) var targ = e.srcElement;

  clear_pop();
}

function pop_button2(e) {
  e = e || window.event;
  if (e.target) var targ = e.target;
  else if (e.srcElement) var targ = e.srcElement;

  clear_pop();
}

function popup(textMsg, butt1Text, func1, butt2Text, func2) {
   if (disp_popup.popList) {
      disp_popup.popList.push({"textMsg":textMsg, "butt1Text":butt1Text, "butt1Func":func1, "butt2Text":butt2Text, "butt2Func":func2});
   } else {
      disp_popup.popList = [{"textMsg":textMsg, "butt1Text":butt1Text, "butt1Func":func1, "butt2Text":butt2Text, "butt2Func":func2}];
   }
   if (disp_popup.popList.length == 1) {
      disp_popup();
   }
}

function okButt() {
  clear_pop();
}

function canButt() {
  clear_pop();
	alert("Cancelled");
}

function disp_popup() { // textMsg, butt1Text, butt2Text) {

   var msgObj = disp_popup.popList[0];
   var textMsg = msgObj["textMsg"];
   var butt1Text = msgObj["butt1Text"];
   var butt1Func = msgObj["butt1Func"];
   var butt2Text = msgObj["butt2Text"];
   var butt2Func = msgObj["butt2Func"];
   grey_page();
   
   var popDiv=document.getElementById("popup_div");   //Get the popup div
   removeKids(popDiv);                                //remove current content

   var popText=document.createElement("p");           //create new content
   popText.innerHTML=textMsg;
   popDiv.appendChild(popText);
   var butt1=document.createElement("input");
   butt1.setAttribute("id","popbutt1");
   butt1.setAttribute("value",butt1Text);
   butt1.setAttribute("type","button");
   popDiv.appendChild(butt1);
   if (typeof(butt2Text) != "undefined") {
     var butt2=document.createElement("input");
      butt2.setAttribute("id","popbutt2");
      butt2.setAttribute("value",butt2Text);
      butt2.setAttribute("type","button");
      popDiv.appendChild(butt2);
   }
   addEvent(document.getElementById('popbutt1'), 'click', butt1Func);  // These should be wrapped within a function that first calls clear_pop()
   if (typeof(butt2Text) != "undefined") {
      addEvent(document.getElementById('popbutt2'), 'click', butt2Func);
   }
   popDiv.style.display='block';
   document.getElementById("popbutt1").focus();
}

function reduce_grid(func, base) {
   var empGrid = document.getElementById("empGridTab");
   for(var i=0; empGrid.rows[i]; i++) {
   	     base = func(base, empGrid.rows[i]);
    }
    return base;
}

function ee_in_grid(emplid) {
   return function(base, row) {
	return base?true:(row.cells[1].innerHTML == emplid);
        }
}

function ee_in_use(emplid) {
    return reduce_grid(ee_in_grid(emplid), false);
}

function replace_ee(newEmplid, rowNum, empListRow, repObj) {
//   alert("Replace " +empListRow.cells[0].innerHTML + " with " +newEmplid);
   rowNum = rowNum - 1;   //rowNum passed in is of empGrid, not empGridBody, so take one off.
   if (ee_in_use(newEmplid))
      alert("Id " +newEmplid + " is in use, choose another.");
   else {
      if (empListRow)
         unChooseEe(empListRow.cells[0]);
      else
         alert("Hmmmm ... didn't find emplid in list, no biggie");
   replace_in_grid(repObj, rowNum);
   currRow = document.getElementById("empGridBody").rows[rowNum];
   addClass(currRow.cells[2],"selected");

   empListRow = findEE(newEmplid);
   if (empListRow)
      chooseEe(empListRow.cells[0]);
   else
      alert("Hmm ... didn't find emplid in list, no biggie");
   eventChanged();
   }
}

function insert_aft(newEmplid, rowNum, empListRow, repObj) {
   var empGrid = document.getElementById("empGridBody");
   if (ee_in_use(newEmplid)) {
      alert("Id " +newEmplid + " is in use, choose another.");
      return false;
     }
   else {
   	var insRow = empGrid.insertRow(rowNum);

//   	currRow = empGrid.rows[rowNum];
//   	addClass(currRow.cells[2],"selected");
   	replace_in_grid(repObj, rowNum);

        empListRow = findEE(newEmplid);
        if (empListRow)
           chooseEe(empListRow.cells[0]);
         else
            alert("Hmm ... didn't find emplid in list, no biggie");
       eventChanged();
       var gridLen = empGrid.length;
       for (var i = 0, row; row = empGrid.rows[i]; i++) {
           row.cells[0].innerHTML = i + 1;
           }
       return true;
   }
}

//Called via click on employee name in the employee pop-up window
function popup_ee(e) {
   e = e || window.event;
   if (e.target) var targ = e.target;
   else if (e.srcElement) var targ = e.srcElement;

   var destDivId = targ.parentNode.parentNode.parentNode.parentNode.parentNode.id;
   var destDiv = document.getElementById(destDivId);

   var empListDivId = destDivId + "_empList";
   var empListTblId = destDivId + "_empTab";
   var empAlphasId  = destDivId + "_empAlphas";
   
   var chkRep = document.getElementById('chkRep').checked;
   var chkIns = document.getElementById('chkIns').checked;
//   var chkEnd = document.getElementById('chkEnd').checked;

   var repObj=buildEeObj(targ);

   var rowNum = document.getElementById("replacerow").getAttribute("rownum");    //index to empGrid hidden in popup div
   var currRow = document.getElementById("empGridTab").rows[rowNum];             //empGrid row
   var oldEmplid = currRow.cells[1].innerHTML;
   var newEmplid = targ.getAttribute("id");
   var empListRow = findEE(oldEmplid);

   if (chkRep)
      replace_ee(newEmplid, rowNum, empListRow, repObj);

   if (chkIns)
      if (insert_aft(newEmplid, rowNum, empListRow, repObj)) {
         document.getElementById("replacerow").setAttribute("rownum", parseFloat(rowNum) + 1);
         un_select_grid();
         addClass(document.getElementById("empGridBody").rows[rowNum].cells[2],'selected');
      }

}
// ,function(){alert("new click"); addEvent_delegate(getElementById('empList2'), "click", selectee);



// clear the class "selected" from all the name fields in the grid
function un_select_grid() {
   loopGrid(function(row) {removeClass(row.cells[2], "selected");});
}

function select_grid(rowNum) {
   addClass();
}

//This handles the event of the user right clicking on a employee name within the function grid of employees already selected for the event.
function disp_listbox (e){
   e = e || window.event;
   if (e.target) var targ = e.target;
   else if (e.srcElement) var targ = e.srcElement;

   var unitId = document.getElementById('unitId').innerHTML.split(" ")[1];
   var modal=document.getElementById("modal");
   modal.style.display='block';
   var popDiv=document.getElementById("listbox_div");   //Get the popup div
   removeKids(popDiv);
//   document.onmousedown=coordinates;
//   document.onmouseup=mouseup;

//   addEvent(popDiv,"mousedown", coordinates);
//   addEvent(popDiv,"mouseup", mouseup);

   var currIdx = targ.parentNode.rowIndex;            //Get row in ee grid that called event
   var emplid = document.getElementById("empGridTab").rows[currIdx].cells[1].innerHTML;
   var eeDiv=document.createElement("div");           //create new content
   eeDiv.setAttribute("id", "replacerow");
   eeDiv.setAttribute("rownum", currIdx);
   popDiv.appendChild(eeDiv);

   var closeBox=document.createElement("img");           //create new content
   closeBox.setAttribute("src", "./images/letterX.png");
   addEvent(closeBox, 'click', function(e){toggle_block("modal"); toggle_block("listbox_div"); un_select_grid(); calcGrid();});
   popDiv.appendChild(closeBox);
   popDiv.style.display='block';
   var delButt = document.createElement("input");
   delButt.setAttribute("id","delButt");
   delButt.setAttribute("value","Delete " + targ.innerHTML +" from here.");
   delButt.setAttribute("type","button");
   addEvent(delButt, "click", function(e) {removeGrid(emplid); empListRow = findEE(emplid); if (empListRow) unChooseEe(empListRow.cells[0]); toggle_block("modal"); toggle_block("listbox_div"); calcGrid(); eventChanged();});
   popDiv.appendChild(delButt);

   var popText=document.createElement("div");           //create new content
   popText.innerHTML="<input type='checkbox' checked='true' id='chkRep'> replace with one of the below";
   popText.setAttribute("id","chkReplace");
   popDiv.appendChild(popText);

   popText=document.createElement("div");           //create new content
   popText.innerHTML="<input type='checkbox' id='chkIns'> insert after selected.";
   popText.setAttribute("id","chkInsAft");
   popDiv.appendChild(popText);

//   popText=document.createElement("div");           //create new content
//   popText.innerHTML="<input type='checkbox' id='chkEnd'> add employees to end.";
//   popText.setAttribute("id","chkAddEnd");
//   popDiv.appendChild(popText);

   eeDiv=document.createElement("div");           //create new content
   eeDiv.setAttribute("id", "popEeDiv");
   popDiv.appendChild(eeDiv);
   listParms={"destDiv":"popEeDiv","listId":"popList", "listTab":"popTabList", "alphaId":"popAlphas", "buttId":"empListButts"};  //was popListButts ... why? cause it didnt work in the popup
   pop_ee_list2(listParms, empList_Events);
}

// more is lost by indecision then wrong decision

function add_new_butts(unitId, funcName) {

   var theform = document.getElementById("todoform");
   var butt1 = document.createElement("input");
   butt1.setAttribute("id","popbutt1");
   butt1.setAttribute("value","Full View");
   butt1.setAttribute("type","button");
   theform.appendChild(butt1);
   addEvent(butt1, 'click', function() {window.open("./" +funcName + ".php?unitId=" +unitId);});
}

function add_csv_butts(unitId, option) {

   var downFile = "./files/" + document.getElementById("download").innerHTML.split(":")[1];

   var theform = document.getElementById("todoform");
   var butt1 = document.createElement("input");
   butt1.setAttribute("id","popbutt1");
   butt1.setAttribute("value","Download");
   butt1.setAttribute("type","button");
   theform.appendChild(butt1);
   addEvent(butt1, 'click', function() {window.open("./download.php?file="+downFile);});

   butt1 = document.createElement("input");
   butt1.setAttribute("id","popbutt2");
   butt1.setAttribute("value","Full View");
   butt1.setAttribute("type","button");
   addEvent(butt1, 'click', function() {window.open("./repWeekCsv.php?unitId="+unitId+"&option="+option);});
   theform.appendChild(butt1);
}

function add_eeSumm_butts(unitId) {

   var theform = document.getElementById("todoform");
   var butt1 = document.createElement("input");
   butt1.setAttribute("id","popbutt2");
   butt1.setAttribute("value","Full View");
   butt1.setAttribute("type","button");
   addEvent(butt1, 'click', function() {window.open("./repWeekEe.php?unitId="+unitId);});
   theform.appendChild(butt1);
}

function add_audit_butts(unitId) {

   var theform = document.getElementById("todoform");
   var butt1 = document.createElement("input");
   butt1.setAttribute("id","popbutt2");
   butt1.setAttribute("value","Full View");
   butt1.setAttribute("type","button");
   addEvent(butt1, 'click', function() {window.open("./auditWeek.php?unitId="+unitId);});
   theform.appendChild(butt1);
}

function add_item(menuId, menuDetails) {
   var menu = document.getElementById(menuId);
   var mItem = document.createElement("li");
   mItem.innerHTML = menuDetails["menuItemDescr"];
   menu.appendChild(mItem);
}

function get_menu(menuId, userId, unitId, destId) {
    var qryString = "?unitId=" + unitId+ "&menuId=" +menuId+ "&userId=" +userId;
    jsonAjax("jsonGetMenuItems", function(json) {var jsonMenu = eval('(' +json+ ')'); for (var menuOpt in jsonMenu) {add_item(jsonMenu[menuOpt]["divId"],jsonMenu[menuOpt]);}}, unitId, qryString);
}

function delWeek(unitId, wkendDate) {
	 clear_pop();
   var parms = "unitId=" + unitId +"&wkendDate="+ wkendDate;
   get2('deleteWeek', parms, 'wkendDets');
}

function doWeek(opt, unitId, wkendDate) {
	popup("Sure you want to "+opt+"?", "Delete", function(){delWeek(unitId, wkendDate)}, "Cancel", canButt);
//	alert("do " + opt + " Unit:"  +unitId +" WE:" + wkendDate);
}

function getWeek() {
   var wkendDate = document.getElementById("wkendDate").value;
   var unitId = document.getElementById("unitId").innerHTML;
 
   var parms = "unitId=" + unitId +"&wkendDate="+ wkendDate +"&buttLab=Delete&buttAct=delete";
   get2('funcsList', parms, 'wkendDets');
}

function date_change(elId) {
	if (elId == "wkendDate")
	   getWeek();
	if (elId =="openCloseDate")
	   wkendDtChg();
}

function delWeekStart(unitId) {
   clearForm();
   var theform = document.getElementById("todoform");

   var label = document.createElement("span");
   label.innerHTML="Week End Date: ";
   theform.appendChild(label);

   var dateFld = document.createElement("input");
   dateFld.setAttribute("type","text");
   dateFld.setAttribute("id","wkendDate");
   addClass(dateFld,'tcal');
   addClass(dateFld,'tcalInput');
   theform.appendChild(dateFld);
   f_tcalInit();

   var hideUnit = document.createElement("span");
   hideUnit.setAttribute("id","unitId");
   hideUnit.innerHTML=unitId;
   addClass(hideUnit,"hidden");
   theform.appendChild(hideUnit);
   
   var resDiv = document.createElement("div");
   resDiv.setAttribute("id","wkendDets");
   theform.appendChild(resDiv);

}