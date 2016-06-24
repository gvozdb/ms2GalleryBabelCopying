var ms2GalleryBabelCopying = function(config)
{
	config = config || {};
	ms2GalleryBabelCopying.superclass.constructor.call(this, config);
};
Ext.extend(ms2GalleryBabelCopying, Ext.Component,
{
	page: {},
	window: {},
	grid: {},
	tree: {},
	panel: {},
	combo: {},
	config: {},
	view: {},
	utils: {},
	actions: {},
});
Ext.reg('ms2gallerybabelcopying', ms2GalleryBabelCopying);

ms2GalleryBabelCopying = new ms2GalleryBabelCopying();



Ext.onReady(function()
{
	ms2GalleryBabelCopying.actions.duplicateImages = function(id)
	{
		if( typeof id != 'undefined' )
		{
			// console.log(id);
			// console.log(ms2GalleryBabelCopyingConfig);

			MODx.msg.confirm({
				title: ms2GalleryBabelCopyingConfig.lexicon.confirm_duplicate_title,
				text: ms2GalleryBabelCopyingConfig.lexicon.confirm_duplicate_text,
				url: ms2GalleryBabelCopyingConfig.connector,
				params: {
					action: 'mgr/gallery/duplicate',
					from: id,
					to: ms2GalleryBabelCopyingConfig.resource_id,
				},
				listeners: {
					success:
					{
						fn: function(r)
						{
							// var panel = Ext.getCmp('ms2gallery-images-panel');
							var view = Ext.getCmp('ms2gallery-images-view');
							view.store.reload();

							console.log('success');
							console.log(r);
						},
						scope: this
					},
					failure:
					{
						fn: function(r)
						{
							console.log('failure');
							console.log(r);
						},
						scope: this
					},
				},
			});
		}
		else {
			// alert('ресурс для этого контекста не определён');
			Ext.Msg.alert(
				'',
				ms2GalleryBabelCopyingConfig.lexicon.error_babel_resource_not_exists,
				function(){},
				this
			);
		}
	};



	var toolbar = Ext.getCmp('ms2gallery-page-toolbar');

	// id ресурса - toolbar.record.id;

	var babelBtn = Ext.getCmp('babel-language-select');

	if( typeof toolbar !== undefined && typeof babelBtn !== undefined )
	{
		// console.log(toolbar);
		// console.log(babelBtn);
		// console.log(babelBtn.initialConfig.menu);

		menus = babelBtn.initialConfig.menu;

		var menu = [];
		for( i in menus )
		{
			if( menus[i]["text"] !== undefined )
			{
				menu.push({
					text: String.format(
						'<span style="{0}"><i class="x-menu-item-icon {1}"></i>{2}</span>',
						'', 'icon icon-files-o', menus[i]["text"]
					),
					iterator: i,
					// handler: ms2GalleryBabelCopying.actions.duplicateImages(menus[i].menu.items[0]["resourceId"]),

					listeners:
					{
						'click': { fn: function(r)
						{
							// console.log(r)
							ms2GalleryBabelCopying.actions.duplicateImages(menus[r.iterator].menu.items[0]["resourceId"]);
						},
						scope: this }
					}
				});
			}
		}

		var button = new Ext.Button({
			id: 'ms2gallery-babel-duplicate-language-select',
			text: 'Duplicate from other languages',
			text: ms2GalleryBabelCopyingConfig.lexicon.duplicate_btn_text,
			menu: menu,
			listeners:
			{
				'menushow': { fn: function(btn, menu)
				{
					// console.log(btn)
					// console.log(menu)
				},
				scope:this}
			}
		});

		toolbar.insertButton(1, [button]);
		toolbar.doLayout();
	}
});