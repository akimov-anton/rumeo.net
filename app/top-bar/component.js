import Ember from 'ember';

export default Ember.Component.extend({
    actions: {
        menuToggle(){
            this.toggleProperty('active');
        },
        clicked(){
            this.toggleProperty('active');
        }
    }
});