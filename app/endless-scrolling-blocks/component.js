import Ember from 'ember';

export default Ember.Component.extend({
    store: Ember.inject.service(),
    page: 1,
    limit: 15,
    videos: [],
    init(){
        this._super(...arguments);
        var self = this;
        window.onscroll = function(){
            var d = document.body;
            //console.log(d.scrollHeight);
            //console.log(endless_block.clientHeight);
            //console.log((endless_block.clientHeight + d.scrollTop) / d.scrollHeight);
            //if (d.scrollHeight - d.scrollTop < 50)
            //    console.log('end');
        };
    },
    click(){
        //var self= this;
        this.incrementProperty('page', 1);
        var params = {};
        params[this.get('param_key')] = this.get('param_value');
        params.page = this.get('page');
        params.limit = this.get('limit');
        this.get('store').query(this.get('object_type'), params).then(videos => {
            if (videos && videos.get('length')) {
                videos.forEach(video => {
                    this.get('videos').pushObject(video);
                });
            }
            console.log(videos.get('length'));
        });

    },
    actions: {
        //scroll(){
        //    console.log('scroll');
        //    var d = document.body;
        //    if (d.clientHeight + d.scrollTop == d.scrollHeight)
        //        console.log('end');
        //}
    }
});
