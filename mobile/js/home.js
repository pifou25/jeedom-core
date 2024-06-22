"use strict";

$("body").attr("data-page", "home");

$("#searchContainer").hide();

var $bottomPanelAnalyseActions;
var $bottomPanelOtherActions;

function initHome() {
  jeedom.refreshMessageNumber();

  //set other analyse:
  $bottomPanelAnalyseActions = $("#bottompanel_analyseActionList");
  $bottomPanelAnalyseActions.empty();
  $bottomPanelAnalyseActions.append(
    '<a class="link ui-bottom-sheet-link ui-btn ui-btn-inline waves-effect waves-button" data-page="timeline" data-title="{{Timeline}}"><i class="far fa-clock"></i> {{Timeline}}</a>',
  );
  $bottomPanelAnalyseActions.append(
    '<a class="link ui-bottom-sheet-link ui-btn ui-btn-inline waves-effect waves-button" data-page="log" data-option="-1" data-title="{{Logs}}"><i class="far fa-file" ></i> {{Logs}}</a>',
  );
  $bottomPanelAnalyseActions.append(
    '<a class="link ui-bottom-sheet-link ui-btn ui-btn-inline waves-effect waves-button" data-page="eqAnalyse" data-title="{{Analyse équipement}}"><i class="fas fa-battery-full"></i> {{Analyse équipement}}</a>',
  );
  $bottomPanelAnalyseActions.append(
    '<a class="link ui-bottom-sheet-link ui-btn ui-btn-inline waves-effect waves-button" data-page="notes" data-title="{{Notes}}"><i class="fas fa-sticky-note"></i> {{Notes}}</a>',
  );
  $bottomPanelAnalyseActions.append(
    '<a class="link ui-bottom-sheet-link ui-btn ui-btn-inline waves-effect waves-button" data-page="cron" data-title="{{Crons}}"><i class="fas fa-cogs"></i> {{Crons}}</a>',
  );
  $bottomPanelAnalyseActions.append(
    '<a class="link ui-bottom-sheet-link ui-btn ui-btn-inline waves-effect waves-button" data-page="deamon" data-title="{{Démons}}"><i class="fas fa-bug"></i> {{Démons}}</a>',
  );
  $bottomPanelAnalyseActions.append(
    '<a class="link ui-bottom-sheet-link ui-btn ui-btn-inline waves-effect waves-button" data-page="health" data-title="{{Santé}}"><i class="icon divers-caduceus3"></i> {{Santé}}</a>',
  );
  $bottomPanelAnalyseActions.append("<br>");

  //set other actions:
  $bottomPanelOtherActions = $("#bottompanel_otherActionList");
  $bottomPanelOtherActions.empty();
  if (
    jeedom.theme.mobile_theme_color != jeedom.theme.mobile_theme_color_night
  ) {
    $bottomPanelOtherActions.append(
      '<a id="bt_switchTheme" class="ui-bottom-sheet-link ui-btn ui-btn-inline waves-effect waves-button"><i class="fas fa-adjust"></i> {{Basculer le thème}}</a>',
    );
  }
  $bottomPanelOtherActions.append(
    '<a class="ui-bottom-sheet-link ui-btn ui-btn-inline waves-effect waves-button" href="index.php?v=d"><i class="fas fa-desktop"></i> {{Version desktop}}</a>',
  );
  $bottomPanelOtherActions.append(
    '<a id="bt_forceReload" class="ui-bottom-sheet-link ui-btn ui-btn-inline waves-effect waves-button"><i class="fas fa-retweet"></i> {{Forcer mise à jour}}</a>',
  );
  if (jeedom.theme.mbState == 0) {
    $bottomPanelOtherActions.append(
      '<a href="https://doc.jeedom.com/" target="_blank" class="ui-bottom-sheet-link ui-btn ui-btn-inline waves-effect waves-button"><i class="fas fa-question-circle"></i> {{Documentation}}</a>',
    );
    $bottomPanelOtherActions.append(
      '<a class="link ui-bottom-sheet-link ui-btn ui-btn-inline waves-effect waves-button" data-page="about" data-title="<i class=\'fas fa-info-circle\'></i> {{A propos}}"><i class="fas fa-info-circle"></i> {{A propos}}</a>',
    );
  }
  $bottomPanelOtherActions.append(
    '<a href="#" id="bt_logout" class="ui-bottom-sheet-link ui-btn ui-btn-inline waves-effect waves-button"><i class="fas fa-sign-out-alt"></i> {{Déconnexion}}</a>',
  );
  $bottomPanelOtherActions.append("<br>");

  //fill bottom menus:
  jeedom.object.all({
    error: function (error) {
      $.fn.showAlert({ message: error.message, level: "danger" });
    },
    success: function (objects) {
      var li = "";
      var summaries = [];
      li +=
        '<a href="#" class="summaryMenu link ui-bottom-sheet-link ui-btn ui-btn-inline waves-effect waves-button" data-page="overview" data-title="<i class=\'fab fa-hubspot\'></i> {{Synthèse}}"><i class="fab fa-hubspot"></i> {{Synthèse}}</a>';
      li +=
        '<a href="#" class="link ui-bottom-sheet-link ui-btn ui-btn-inline waves-effect waves-button" data-page="equipment" data-title="<i class=\'fas fa-globe\'></i> {{Tous}}" data-option="all"><i class="fas fa-globe"></i> {{Tous}}</a>';
      var icon, decay;
      for (var i in objects) {
        if (objects[i].isVisible == 1) {
          icon = "";
          if (isset(objects[i].display) && isset(objects[i].display.icon)) {
            icon = objects[i].display.icon;
          }
          decay = 0;
          if (
            isset(objects[i].configuration) &&
            isset(objects[i].configuration.parentNumber)
          ) {
            decay = objects[i].configuration.parentNumber;
          }
          li +=
            '<a href="#" class="link ui-bottom-sheet-link ui-btn ui-btn-inline waves-effect waves-button" data-page="equipment" data-title="' +
            icon.replace(/\"/g, "'") +
            " " +
            objects[i].name.replace(/\"/g, "'") +
            '" data-option="' +
            objects[i].id +
            '">';
          li +=
            "<span>" +
            "&nbsp;&nbsp;".repeat(decay) +
            icon +
            "</span> " +
            objects[i].name;
          li +=
            '<span class="summaryMenu"><span class="objectSummary' +
            objects[i].id +
            '" data-version="mobile"></span></span></a>';
          summaries.push({ object_id: objects[i].id });
        }
      }
      $("#bottompanel_objectList").empty().append(li);
      jeedom.object.summaryUpdate(summaries);
    },
  });

  jeedom.view.all({
    error: function (error) {
      $.fn.showAlert({ message: error.message, level: "danger" });
    },
    success: function (views) {
      if (views.length) {
        var li = "";
        var icon;
        for (var i in views) {
          icon = "";
          if (isset(views[i].display) && isset(views[i].display.icon)) {
            icon = views[i].display.icon;
          }
          li +=
            '<a href="#" class="link ui-bottom-sheet-link ui-btn ui-btn-inline waves-effect waves-button" data-page="view" data-title="' +
            icon.replace(/\"/g, "'") +
            " " +
            views[i].name +
            '" data-option="' +
            views[i].id +
            '">' +
            icon +
            " " +
            views[i].name +
            "</a>";
        }
        $("#bottompanel_viewList").empty().append(li);
      }
    },
  });

  jeedom.plan.allHeader({
    error: function (error) {
      $.fn.showAlert({ message: error.message, level: "danger" });
    },
    success: function (planHeader) {
      if (planHeader.length) {
        var li = "";
        var icon;
        for (var i in planHeader) {
          icon = "";
          if (
            isset(planHeader[i].configuration) &&
            isset(planHeader[i].configuration.icon)
          ) {
            icon = planHeader[i].configuration.icon;
          }
          li +=
            '<a class="ui-bottom-sheet-link ui-btn ui-btn-inline waves-effect waves-button" href="index.php?v=d&p=plan&plan_id=' +
            planHeader[i].id +
            '" data-ajax="false">' +
            icon +
            " " +
            planHeader[i].name +
            "</a>";
        }
        $("#bottompanel_planList")
          .empty()
          .append(
            '<span class="ui-bottom-sheet-link ui-bottom-sheet-sep">&#160&#160&#160 <i class="fas fa-paint-brush"></i> {{Designs}} <i class="fas fa-sort-down"></i></span>',
          );
        $("#bottompanel_planList").append(li);
      }
    },
  });

  jeedom.plan3d.allHeader({
    error: function (error) {
      $.fn.showAlert({ message: error.message, level: "danger" });
    },
    success: function (plan3dHeader) {
      if (plan3dHeader.length) {
        var li = "";
        var icon;
        for (var i in plan3dHeader) {
          icon = "";
          if (
            isset(plan3dHeader[i].configuration) &&
            isset(plan3dHeader[i].configuration.icon)
          ) {
            icon = plan3dHeader[i].configuration.icon;
          }
          li +=
            '<a class="ui-bottom-sheet-link ui-btn ui-btn-inline waves-effect waves-button" href="index.php?v=d&p=plan3d&plan3d_id=' +
            plan3dHeader[i].id +
            '&fullscreen=1" data-ajax="false">' +
            icon +
            " " +
            plan3dHeader[i].name +
            "</a>";
        }
        $("#bottompanel_planList").append(
          '<span class="ui-bottom-sheet-link ui-bottom-sheet-sep">&#160&#160&#160 <i class="fas fa-cubes"></i> {{Designs 3D}} <i class="fas fa-sort-down"></i></span>',
        );
        $("#bottompanel_planList").append(li);
      }
    },
  });

  if (plugins.length > 0) {
    var li = "";
    for (var i in plugins) {
      if (plugins[i].mobile == "") continue;
      if (plugins[i].displayMobilePanel == 0) continue;

      li +=
        '<a href="#" class="link ui-bottom-sheet-link ui-btn ui-btn-inline waves-effect waves-button" data-page="' +
        plugins[i].mobile +
        '" data-plugin="' +
        plugins[i].id +
        '" data-title="' +
        plugins[i].name +
        '">';
      li +=
        '<img src="plugins/' +
        plugins[i].id +
        "/plugin_info/" +
        plugins[i].id +
        '_icon.png" onerror=\'this.style.display = "none"\' /> ';
      li += plugins[i].name;
      li += "</a>";
    }
    if (li != "") {
      $("#bottompanel_pluginList").empty().append(li);
    } else {
      $("#bt_listPlugin").hide();
    }
  } else {
    $("#bt_listPlugin").hide();
  }

  //buttons:
  $("#bt_logout")
    .off("click")
    .on("click", function () {
      $.ajax({
        type: "POST",
        url: "core/ajax/user.ajax.php",
        data: {
          action: "logout",
        },
        dataType: "json",
        error: function (request, status, error) {
          handleAjaxError(request, status, error, $("#div_alert"));
        },
        success: function (data) {
          if (data.state != "ok") {
            $.fn.showAlert({ message: data.result, level: "danger" });
            return;
          }
          jeedomUtils.initApplication();
        },
      });
    });

  $("#bt_forceReload")
    .off("click")
    .on("click", function () {
      window.location.reload(true);
    });

  jeedom.version({
    success: function (version) {
      $("#homeVersion").html(version);
    },
  });

  function loadConfig(_key) {
    jeedom.config.load({
      configuration: _key,
      success: function (data) {
        if (_key == "name") {
          $("#jeedomName").html(data);
        }
        if (_key == "product_name") {
          var txt = $("#jeedomName").text();
          $("#jeedomName").html(txt + "<br> WebApp " + data);
        }
        if (_key == "mbState") {
          if (data != 0) {
            $("#path2899").hide();
          } else {
            $("#path2899").show();
          }
        }
      },
    });
  }

  loadConfig("name");
  loadConfig("mbState");
  loadConfig("product_name");

  if (!APP_MODE) {
    setTimeout(function () {
      $("#pagecontainer").css("padding-top", "72px");
    }, 100);
  }
}
