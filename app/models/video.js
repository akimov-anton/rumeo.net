import DS from 'ember-data';
import Ember from 'ember';

export default DS.Model.extend({
    source: DS.attr('string'),
    title: DS.attr('string'),
    category: DS.belongsTo('video-category'),
    youtubeHash: DS.attr('string'),
    isYoutube: Ember.computed('source', function () {
        return this.get('source').indexOf('youtube.com') !== -1;
    }),
    youtubeId: Ember.computed('isYoutube', function () {
        if (this.get('isYoutube')) {
            return/(embed\/)(.{11})/.exec(this.get('source'))[2];
        }
    })
});
