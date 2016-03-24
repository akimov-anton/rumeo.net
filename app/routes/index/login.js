import Ember from 'ember';

export default Ember.Route.extend({
    session: Ember.inject.service(),
    model(){
        return this.store.createRecord('user');
    },
    actions: {
        login(user){
            this.store.queryRecord('user', {login: user.get('name'), pass: user.get('pass')}).then(valid_user => {
                console.log('THEN');
                this.get('session').setItem('_hash', valid_user.get('hash'));
                this.get('session').login(valid_user);
                this.transitionTo('index');
            }).catch(error => {
                console.log(error);
                user.get('errors').clear();
                user.get('errors').add('secure', 'Неправильный логин или пароль');
            });
        }
    }
});
