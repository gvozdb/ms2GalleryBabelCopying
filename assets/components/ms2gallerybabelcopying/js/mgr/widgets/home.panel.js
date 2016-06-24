ms2GalleryBabelCopying.panel.Home = function (config) {
	config = config || {};
	Ext.apply(config, {
		baseCls: 'modx-formpanel',
		layout: 'anchor',
		/*
		 stateful: true,
		 stateId: 'ms2gallerybabelcopying-panel-home',
		 stateEvents: ['tabchange'],
		 getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
		 */
		hideMode: 'offsets',
		items: [{
			html: '<h2>' + _('ms2gallerybabelcopying') + '</h2>',
			cls: '',
			style: {margin: '15px 0'}
		}, {
			xtype: 'modx-tabs',
			defaults: {border: false, autoHeight: true},
			border: true,
			hideMode: 'offsets',
			items: [{
				title: _('ms2gallerybabelcopying_items'),
				layout: 'anchor',
				items: [{
					html: _('ms2gallerybabelcopying_intro_msg'),
					cls: 'panel-desc',
				}, {
					xtype: 'ms2gallerybabelcopying-grid-items',
					cls: 'main-wrapper',
				}]
			}]
		}]
	});
	ms2GalleryBabelCopying.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(ms2GalleryBabelCopying.panel.Home, MODx.Panel);
Ext.reg('ms2gallerybabelcopying-panel-home', ms2GalleryBabelCopying.panel.Home);
