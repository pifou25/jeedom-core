/*
 Highstock JS v9.3.2 (2021-11-29)

 Indicator series type for Highcharts Stock

 (c) 2010-2021 Pawe Dalek

 License: www.highcharts.com/license
*/
'use strict';(function(b){"object"===typeof module&&module.exports?(b["default"]=b,module.exports=b):"function"===typeof define&&define.amd?define("highcharts/indicators/volume-by-price",["highcharts","highcharts/modules/stock"],function(d){b(d);b.Highcharts=d;return b}):b("undefined"!==typeof Highcharts?Highcharts:void 0)})(function(b){function d(b,k,d,q){b.hasOwnProperty(k)||(b[k]=q.apply(null,d))}b=b?b._modules:{};d(b,"Stock/Indicators/VBP/VBPPoint.js",[b["Core/Series/Point.js"],b["Core/Series/SeriesRegistry.js"]],
function(b,k){var d=this&&this.__extends||function(){var b=function(a,d){b=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(b,a){b.__proto__=a}||function(b,a){for(var d in a)a.hasOwnProperty(d)&&(b[d]=a[d])};return b(a,d)};return function(a,d){function k(){this.constructor=a}b(a,d);a.prototype=null===d?Object.create(d):(k.prototype=d.prototype,new k)}}();return function(k){function a(){return null!==k&&k.apply(this,arguments)||this}d(a,k);a.prototype.destroy=function(){this.negativeGraphic&&
(this.negativeGraphic=this.negativeGraphic.destroy());return b.prototype.destroy.apply(this,arguments)};return a}(k.seriesTypes.sma.prototype.pointClass)});d(b,"Stock/Indicators/VBP/VBPIndicator.js",[b["Stock/Indicators/VBP/VBPPoint.js"],b["Core/Animation/AnimationUtilities.js"],b["Core/Globals.js"],b["Core/Series/SeriesRegistry.js"],b["Core/Utilities.js"],b["Core/Chart/StockChart.js"]],function(b,d,C,q,a,H){var k=this&&this.__extends||function(){var b=function(a,c){b=Object.setPrototypeOf||{__proto__:[]}instanceof
Array&&function(c,b){c.__proto__=b}||function(c,b){for(var e in b)b.hasOwnProperty(e)&&(c[e]=b[e])};return b(a,c)};return function(a,c){function x(){this.constructor=a}b(a,c);a.prototype=null===c?Object.create(c):(x.prototype=c.prototype,new x)}}(),I=d.animObject;d=C.noop;var D=q.seriesTypes.sma,z=a.addEvent,E=a.arrayMax,J=a.arrayMin,A=a.correctFloat,F=a.defined,B=a.error,G=a.extend,K=a.isArray,L=a.merge,v=Math.abs,y=q.seriesTypes.column.prototype;a=function(b){function a(){var c=null!==b&&b.apply(this,
arguments)||this;c.data=void 0;c.negWidths=void 0;c.options=void 0;c.points=void 0;c.posWidths=void 0;c.priceZones=void 0;c.rangeStep=void 0;c.volumeDataArray=void 0;c.zoneStarts=void 0;c.zoneLinesSVG=void 0;return c}k(a,b);a.prototype.init=function(c){var b=this,a,e,l;C.seriesTypes.sma.prototype.init.apply(b,arguments);var r=z(H,"afterLinkSeries",function(){b.options&&(a=b.options.params,e=b.linkedParent,l=c.get(a.volumeSeriesID),b.addCustomEvents(e,l));r()},{order:1});return b};a.prototype.addCustomEvents=
function(c,b){function a(){e.chart.redraw();e.setData([]);e.zoneStarts=[];e.zoneLinesSVG&&(e.zoneLinesSVG=e.zoneLinesSVG.destroy())}var e=this;e.dataEventsToUnbind.push(z(c,"remove",function(){a()}));b&&e.dataEventsToUnbind.push(z(b,"remove",function(){a()}));return e};a.prototype.animate=function(c){var b=this,a=b.chart.inverted,e=b.group,l={};!c&&e&&(c=a?b.yAxis.top:b.xAxis.left,a?(e["forceAnimate:translateY"]=!0,l.translateY=c):(e["forceAnimate:translateX"]=!0,l.translateX=c),e.animate(l,G(I(b.options.animation),
{step:function(c,a){b.group.attr({scaleX:Math.max(.001,a.pos)})}})))};a.prototype.drawPoints=function(){this.options.volumeDivision.enabled&&(this.posNegVolume(!0,!0),y.drawPoints.apply(this,arguments),this.posNegVolume(!1,!1));y.drawPoints.apply(this,arguments)};a.prototype.posNegVolume=function(b,a){var c=a?["positive","negative"]:["negative","positive"],e=this.options.volumeDivision,l=this.points.length,r=[],f=[],h=0,d;b?(this.posWidths=r,this.negWidths=f):(r=this.posWidths,f=this.negWidths);for(;h<
l;h++){var g=this.points[h];g[c[0]+"Graphic"]=g.graphic;g.graphic=g[c[1]+"Graphic"];if(b){var x=g.shapeArgs.width;var n=this.priceZones[h];(d=n.wholeVolumeData)?(r.push(x/d*n.positiveVolumeData),f.push(x/d*n.negativeVolumeData)):(r.push(0),f.push(0))}g.color=a?e.styles.positiveColor:e.styles.negativeColor;g.shapeArgs.width=a?this.posWidths[h]:this.negWidths[h];g.shapeArgs.x=a?g.shapeArgs.x:this.posWidths[h]}};a.prototype.translate=function(){var b=this,a=b.options,d=b.chart,e=b.yAxis,l=e.min,r=b.options.zoneLines,
f=b.priceZones,h=0,m,g,u;y.translate.apply(b);var n=b.points;if(n.length){var k=.5>a.pointPadding?a.pointPadding:.1;a=b.volumeDataArray;var t=E(a);var p=d.plotWidth/2;var M=d.plotTop;var w=v(e.toPixels(l)-e.toPixels(l+b.rangeStep));var q=v(e.toPixels(l)-e.toPixels(l+b.rangeStep));k&&(l=v(w*(1-2*k)),h=v((w-l)/2),w=v(l));n.forEach(function(a,c){g=a.barX=a.plotX=0;u=a.plotY=e.toPixels(f[c].start)-M-(e.reversed?w-q:w)-h;m=A(p*f[c].wholeVolumeData/t);a.pointWidth=m;a.shapeArgs=b.crispCol.apply(b,[g,u,
m,w]);a.volumeNeg=f[c].negativeVolumeData;a.volumePos=f[c].positiveVolumeData;a.volumeAll=f[c].wholeVolumeData});r.enabled&&b.drawZones(d,e,b.zoneStarts,r.styles)}};a.prototype.getValues=function(b,a){var c=b.processedXData,e=b.processedYData,d=this.chart,r=a.ranges,f=[],h=[],m=[],g;if(b.chart)if(g=d.get(a.volumeSeriesID))if((a=K(e[0]))&&4!==e[0].length)B("Type of "+b.name+" series is different than line, OHLC or candlestick.",!0,d);else return(this.priceZones=this.specifyZones(a,c,e,r,g)).forEach(function(b,
a){f.push([b.x,b.end]);h.push(f[a][0]);m.push(f[a][1])}),{values:f,xData:h,yData:m};else B("Series "+a.volumeSeriesID+" not found! Check `volumeSeriesID`.",!0,d);else B("Base series not found! In case it has been removed, add a new one.",!0,d)};a.prototype.specifyZones=function(b,a,d,e,l){if(b){var c=d.length;for(var f=d[0][3],h=f,m=1,g;m<c;m++)g=d[m][3],g<f&&(f=g),g>h&&(h=g);c={min:f,max:h}}else c=!1;c=(f=c)?f.min:J(d);g=f?f.max:E(d);f=this.zoneStarts=[];h=[];var k=0;m=1;var n=this.linkedParent;
!this.options.compareToMain&&n.dataModify&&(c=n.dataModify.modifyValue(c),g=n.dataModify.modifyValue(g));if(!F(c)||!F(g))return this.points.length&&(this.setData([]),this.zoneStarts=[],this.zoneLinesSVG&&(this.zoneLinesSVG=this.zoneLinesSVG.destroy())),[];n=this.rangeStep=A(g-c)/e;for(f.push(c);k<e-1;k++)f.push(A(f[k]+n));f.push(g);for(e=f.length;m<e;m++)h.push({index:m-1,x:a[0],start:f[m-1],end:f[m]});return this.volumePerZone(b,h,l,a,d)};a.prototype.volumePerZone=function(b,a,d,e,l){var c=this,
f=d.processedXData,h=d.processedYData,k=a.length-1,g=l.length;d=h.length;var u,n,q,t,p;v(g-d)&&(e[0]!==f[0]&&h.unshift(0),e[g-1]!==f[d-1]&&h.push(0));c.volumeDataArray=[];a.forEach(function(a){a.wholeVolumeData=0;a.positiveVolumeData=0;for(p=a.negativeVolumeData=0;p<g;p++){q=n=!1;t=b?l[p][3]:l[p];u=p?b?l[p-1][3]:l[p-1]:t;var d=c.linkedParent;!c.options.compareToMain&&d.dataModify&&(t=d.dataModify.modifyValue(t),u=d.dataModify.modifyValue(u));t<=a.start&&0===a.index&&(n=!0);t>=a.end&&a.index===k&&
(q=!0);(t>a.start||n)&&(t<a.end||q)&&(a.wholeVolumeData+=h[p],u>t?a.negativeVolumeData+=h[p]:a.positiveVolumeData+=h[p])}c.volumeDataArray.push(a.wholeVolumeData)});return a};a.prototype.drawZones=function(a,b,d,e){var c=a.renderer,k=this.zoneLinesSVG,f=[],h=a.plotWidth,m=a.plotTop,g;d.forEach(function(c){g=b.toPixels(c)-m;f=f.concat(a.renderer.crispLine([["M",0,g],["L",h,g]],e.lineWidth))});k?k.animate({d:f}):k=this.zoneLinesSVG=c.path(f).attr({"stroke-width":e.lineWidth,stroke:e.color,dashstyle:e.dashStyle,
zIndex:this.group.zIndex+.1}).add(this.group)};a.defaultOptions=L(D.defaultOptions,{params:{index:void 0,period:void 0,ranges:12,volumeSeriesID:"volume"},zoneLines:{enabled:!0,styles:{color:"#0A9AC9",dashStyle:"LongDash",lineWidth:1}},volumeDivision:{enabled:!0,styles:{positiveColor:"rgba(144, 237, 125, 0.8)",negativeColor:"rgba(244, 91, 91, 0.8)"}},animationLimit:1E3,enableMouseTracking:!1,pointPadding:0,zIndex:-1,crisp:!0,dataGrouping:{enabled:!1},dataLabels:{allowOverlap:!0,enabled:!0,format:"P: {point.volumePos:.2f} | N: {point.volumeNeg:.2f}",
padding:0,style:{fontSize:"7px"},verticalAlign:"top"}});return a}(D);G(a.prototype,{nameBase:"Volume by Price",nameComponents:["ranges"],calculateOn:{chart:"render",xAxis:"afterSetExtremes"},pointClass:b,markerAttribs:d,drawGraph:d,getColumnMetrics:y.getColumnMetrics,crispCol:y.crispCol});q.registerSeriesType("vbp",a);"";return a});d(b,"masters/indicators/volume-by-price.src.js",[],function(){})});
//# sourceMappingURL=volume-by-price.js.map