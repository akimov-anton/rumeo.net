import Ember from 'ember';

export default Ember.Route.extend({
    session: Ember.inject.service(),
    model(){
        return {
            //user: this.get('session').getUser(),
            categories: this.store.findAll('video-category')
        }
    }
});
