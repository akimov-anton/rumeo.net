import Ember from 'ember';

export default Ember.Route.extend({
    model(){
        return {
            categories: this.store.findAll('video-category')
        }
    }
});
