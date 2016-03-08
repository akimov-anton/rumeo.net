import Ember from 'ember';

export default Ember.Component.extend({
    video: '',
    isYoutube: Ember.computed('video.source', function () {
        return this.get('video').get('source').indexOf('youtube.com') !== -1;
    }),
    imgUrl: Ember.computed('isYoutube', function(){
        if(this.get('isYoutube')){
            var hash = /(embed\/)(.{11})/.exec(this.get('video').get('source'))[2];
            return `http://img.youtube.com/vi/${hash}/0.jpg`;
        }
    }),
    init(){
        this._super(...arguments);
    }
});
