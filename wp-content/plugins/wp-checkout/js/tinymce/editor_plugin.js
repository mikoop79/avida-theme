/**
 * Checkout TinyMCE Plugin
 * @author Tribulant Software
 */

(function() {
	// Load plugin specific language pack
	tinymce.PluginManager.requireLangPack("Checkout");

	tinymce.create('tinymce.plugins.Checkout', {
		init: function(ed, url) {
			ed.addCommand('mceCheckout', function() {			
				ed.windowManager.open({
					//file : url + '/dialog.php',
					file: ajaxurl + '?action=wpcodialog',
					width : 400,
					height : 280,
					inline : 1
				}, {
					plugin_url : url // Plugin absolute URL
				});
			});

			// Register example button
			ed.addButton('Checkout', {
				title : 'Checkout.desc',
				cmd : 'mceCheckout',
				image : url + '/icon-20.png'
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			/*ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('Checkout', n.nodeName == 'IMG');
			});*/
			
			
		},		
		createControl : function(n, cm) {
			return null;
		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'Checkout TinyMCE Plugin',
				author : 'Tribulant Software',
				authorurl : 'http://tribulant.com',
				infourl : 'http://tribulant.com',
				version : "1.0"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('Checkout', tinymce.plugins.Checkout);
})();