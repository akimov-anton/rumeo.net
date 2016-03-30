import Ember from 'ember';

export default Ember.Component.extend({
    store: Ember.inject.service(),
    page: 1,
    limit: 15,
    videos: [],
    init(){
        this._super(...arguments);
        this.get('videos').clear();
        var self = this;
        window.onscroll = function(){
            var d = document.body;
            if (d.scrollTop + $(window).height() >= d.scrollHeight)
                self.loadData();
        };
    },
    loadData(){
        this.set('loading', true);
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
            this.set('loading', false);
            console.log(videos.get('length'));
        }).catch(error => {
            this.set('loading', false);
        });
    },
    actions: {
    }
});
