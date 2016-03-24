import Ember from 'ember';

export default Ember.Component.extend({
    session: Ember.inject.service(),
    user: Ember.computed('session.user', function(){
       return this.get('session').getUser();
    }),
    actions: {
        menuToggle(){
            this.toggleProperty('active');
        },
        clicked(){
            this.toggleProperty('active');
        },
        logout(){
            this.get('session').logout();
        }
    }
});