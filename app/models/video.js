import DS from 'ember-data';

export default DS.Model.extend({
  source: DS.attr('string'),
  category: DS.belongsTo('video-category')
});
