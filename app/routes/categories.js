import Ember from 'ember';

export default Ember.Route.extend({
    model(){
        return this.store.peekAll('video-category').get('length') ?
            this.store.peekAll('video-category') : this.store.findAll('video-category')
    }
});
