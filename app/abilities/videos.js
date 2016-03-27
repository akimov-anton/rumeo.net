import Ember from 'ember';
import { Ability } from 'ember-can';

export default Ability.extend({
    session: Ember.inject.service(),
    store: Ember.inject.service(),
    user: Ember.computed('session', function () {
        return this.get('session').get('user');
    }),
    canAdd: Ember.computed('session.user.role', function () {
        if (this.get('user'))
            return this.get('user').get('role') == 1;
    }),
    canEdit: Ember.computed('session.user.role', function () {
        if (this.get('user'))
            return this.get('user').get('role') == 1;
    }),
});