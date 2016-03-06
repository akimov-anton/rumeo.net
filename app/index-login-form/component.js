import Ember from 'ember';

export default Ember.Component.extend({
    reg_mode: false,
    actions: {
        changeMode(){
            this.toggleProperty('reg_mode');
        }
    }
});
