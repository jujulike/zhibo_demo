/*******************************************************************************
* @author panderman <panderman@163.com>
* @site http://www.xunwee.com/
* @licence http://www.kindsoft.net/license.php
*******************************************************************************/

KindEditor.plugin('flower', function (K) {
    var self = this, name = 'flower',
		path = self.pluginsPath + 'flower/images/';
    self.clickToolbar(name, function () {
			self.insertHtml('<img src="'+path+'63.gif">');
        });
});
