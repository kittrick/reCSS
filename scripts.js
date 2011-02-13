/**
 * jQuery.ajax mid - CROSS DOMAIN AJAX 
 * ---
 * @author James Padolsey (http://james.padolsey.com)
 * @version 0.11
 * @updated 12-JAN-10
 * ---
 * Note: Read the README!
 * ---
 * @info http://james.padolsey.com/javascript/cross-domain-requests-with-jquery/
 */

jQuery.ajax = (function(_ajax){
    
    var protocol = location.protocol,
        hostname = location.hostname,
        exRegex = RegExp(protocol + '//' + hostname),
        YQL = 'http' + (/^https/.test(protocol)?'s':'') + '://query.yahooapis.com/v1/public/yql?callback=?',
        query = 'select * from html where url="{URL}" and xpath="*"';
    
    function isExternal(url) {
        return !exRegex.test(url) && /:\/\//.test(url);
    }
    
    return function(o) {
        
        var url = o.url;
        
        if ( /get/i.test(o.type) && !/json/i.test(o.dataType) && isExternal(url) ) {
            
            // Manipulate options so that JSONP-x request is made to YQL
            
            o.url = YQL;
            o.dataType = 'json';
            
            o.data = {
                q: query.replace(
                    '{URL}',
                    url + (o.data ?
                        (/\?/.test(url) ? '&' : '?') + jQuery.param(o.data)
                    : '')
                ),
                format: 'xml'
            };
            
            // Since it's a JSONP request
            // complete === success
            if (!o.success && o.complete) {
                o.success = o.complete;
                delete o.complete;
            }
            
            o.success = (function(_success){
                return function(data) {
                    
                    if (_success) {
                        // Fake XHR callback.
                        _success.call(this, {
                            responseText: data.results[0]
                                // YQL screws with <script>s
                                // Get rid of them
                                .replace(/<script[^>]+?\/>|<script(.|\s)*?\/script>/gi, '')
                        }, 'success');
                    }
                    
                };
            })(o.success);
            
        }
        
        return _ajax.apply(this, arguments);
        
    };
    
})(jQuery.ajax);

$(function(){
	textarea = $('<textarea wrap="off" />').hide();
	$('fieldset').append('<hr>').append(textarea);
	$('#form').submit(function(ev){
		ev.preventDefault();
		$('#loading').css('background','url(loading.gif) top left no-repeat');
		$('h3').slideUp('slow',function(){
			$(this).remove();
		});
		$('div').slideUp('slow',function(){
			$(this).remove();
		});
		$('hr.error').remove();
		
		$url = $('#url').val();
		if($url.indexOf('http://') !== 0 && $url !== ''){
			$url = 'http://'+$url;
		}
		$.ajax({
			url: $url,
			type: 'GET',
			statusCode: {
				404: function() {
					$('#status').html('404 not found. Try again?');
					$('#loading').css('background','none');
				},
				200: function() {
					$('#status').html('Success! Again?');
				}
			},
			success: function(data){
				var xml = data.responseText || data;
				
					/* Strip Newlines */
					xml = xml.replace(/\n/g,'<4b576e26f68e1a0a5792019088bd0442 />'); /* md5 hash of pikachu */
					
					/* Strip Content */
					xml = xml.replace(/>.*?</g,'><');
					
					/* Remove Head (ha!) */
					xml = xml.replace(/<head>.*?<\/head>/g,'');
					
					/* Remove Doctype */
					xml = xml.replace(/<[!](doctype|DOCTYPE).*?>/g,'');
					
					/* Remove Comments */
					xml = xml.replace(/<!--.*?-->/g,'');
					xml = xml.replace(/<!--.*?>/g,'');
					xml = xml.replace(/<!.*?-->/g,'');
					
					/* Strip Tags */
					xml = xml.replace(/(lang|title|rel|href|dir|charset|http-equiv|alt|src|role|type|target|style)="(.*?)"/g,'');
					
					/* fix some basic errors */
					xml = xml.replace(/<(.*?)[^>]</g,'<\$1><');
					xml = xml.replace(/xml:/g,'');
					
					/* Replace Newlines for Debugging */
					xml = xml.replace(/<4b576e26f68e1a0a5792019088bd0442 \/>/g,'\n')
					console.log(xml);
					xml = $.parseXML(xml);
					
					var selectorArray = new Array();
					
					/* http://www.webdeveloper.com/forum/showthread.php?t=44892 */
					Array.prototype.exists = function(search){
					for (var i=0; i<this.length; i++)
						if (this[i] == search) return true;
						return false;
					}
					
					/* http://snipplr.com/view.php?codeview&id=13523 */
					if (!window.getComputedStyle) {
					    window.getComputedStyle = function(el, pseudo) {
					        this.el = el;
					        this.getPropertyValue = function(prop) {
					            var re = /(\-([a-z]){1})/g;
					            if (prop == 'float') prop = 'styleFloat';
					            if (re.test(prop)) {
					                prop = prop.replace(re, function () {
					                    return arguments[2].toUpperCase();
					                });
					            }
					            return el.currentStyle[prop] ? el.currentStyle[prop] : null;
					        }
					        return this;
					    }
					}
					
					function addToreCSS(domElement,tabs){
						if(domElement.nodeName == '#document'){
							$(domElement).children().each(function(){
								addToreCSS(this,tabs);
							})
						}else if(domElement.nodeName == 'parsererror'){
							error = $(domElement).html();
							$('#status').after('<hr class="error" />'+error);
							$('h3, div').hide().slideDown('slow');
						}else{
							selector = '';
							if(window.undefined !== domElement.nodeName){
								selector += domElement.nodeName;
							}
							if(window.undefined !== $(domElement).attr('class')){
								class = $(domElement).attr('class').split(' ');
								class = class.join('.');
								selector += '.'+class;
								selector = selector.replace(/\.+/g,'.');
							}
							if(window.undefined !== $(domElement).attr('id')){
								id = $(domElement).attr('id').split(' ');
								id = id.join('#');
								selector += '#'+id;
							}
							if(!selectorArray.exists(selector)){
								selectorArray.push(selector);
								reCSS += tabs+selector+' {\n'+tabs+'\n'+tabs+'}\n\n';
								if(domElement.hasChildNodes()){
									tabs += '  ';
									$(domElement).children().each(function(){
										addToreCSS(this,tabs);
									})
								}
							}else{
								tabs += '  ';
								$(domElement).children().each(function(){
									addToreCSS(this,tabs);
								})
							}
						}
					}
					var reCSS = '';
					var tabs = '';
					addToreCSS(xml,tabs);
					textarea.hide();
					textarea.html(reCSS);
					textarea.slideDown('slow',function(){
						this.focus();
						this.select();
					});
					$('#loading').css('background','none');
			}
		});
	});
});