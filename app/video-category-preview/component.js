import Ember from 'ember';

export default Ember.Component.extend({
    store: Ember.inject.service(),
    videos: [],
    video1: Ember.computed('videos', function () {
        if (this.get('videos').get('length')) {
            return this.get('videos').objectAt(0);
        }
    }),
    video2: Ember.computed('videos', function () {
        if (this.get('videos').get('length')) {
            return this.get('videos').objectAt(1);
        }
    }),
    video3: Ember.computed('videos', function () {
        if (this.get('videos').get('length')) {
            return this.get('videos').objectAt(2);
        }
    }),
    video4: Ember.computed('videos', function () {
        if (this.get('videos').get('length')) {
            return this.get('videos').objectAt(3);
        }
    }),
    video5: Ember.computed('videos', function () {
        if (this.get('videos').get('length')) {
            return this.get('videos').objectAt(4);
        }
    }),
    init(){
        this._super(...arguments);
        this.set('videos', []);
        this.get('store').query('video', {category: this.get('category_id'), limit: 5}).then(videos => {
            //videos.forEach(video => {
            //    this.get('videos').pushObject(video);
            //});
            //this.get('videos').pushObjects(videos);
            this.set('videos', videos);
        });
    }
});