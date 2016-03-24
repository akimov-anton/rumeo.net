import DS from 'ember-data';
import Ember from 'ember';

export default DS.Model.extend({
    name: DS.attr('string'),
    role: DS.attr('number'),
    pass: DS.attr('string')
});