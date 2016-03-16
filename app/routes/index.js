import Ember from 'ember';

export default Ember.Route.extend({
    model(){
        return {
            top_videos: this.store.query('video', {top: true}),
            categories: this.store.peekAll('video-category')
        };
    }
});
