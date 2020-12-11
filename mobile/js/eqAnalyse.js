"use strict"

$('body').attr('data-page', 'eqAnalyse')

function initEqanalyse() {
  deviceInfo = getDeviceType()
  jeedom.eqLogic.htmlAlert({
    version : 'mobile',
    error: function(error) {
      $('#div_alert').showAlert({message: error.message, level: 'danger'})
    },
    success: function(eqLogics) {
      var div = ''
      for (var i in eqLogics) {
        div += eqLogics[i].html
      }
      $('#div_displayAlert').empty().html(div).trigger('create')
      setTileSize('.eqLogic')
      setTimeout(function() {
        $('#div_displayAlert').packery({gutter : 0})
      }, 100)

      jeedom.eqLogic.htmlBattery({
        version : 'mobile',
        error: function(error) {
          $('#div_alert').showAlert({message: error.message, level: 'danger'})
        },
        success: function(eqLogics) {
          var div = ''
          for (var i in eqLogics) {
            div += eqLogics[i].html
          }
          $('#div_displayBattery').empty().html(div).trigger('create')
          $('ul[data-role=nd2tabs]').tabs()
          setTileSize('.eqLogic')
        }
      })
    }
  })

  $('body').on('orientationChanged', function(event, _orientation) {
    setTileSize('.eqLogic')
    $('#div_displayAlert').packery({gutter : 0})
  })
}