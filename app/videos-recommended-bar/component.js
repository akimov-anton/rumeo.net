import Ember from 'ember';

export default Ember.Component.extend({
    store: Ember.inject.service(),
    videos: Ember.computed('category_id', function(){
       if(this.get('category_id')){
           return this.get('store').query('video', {category: this.get('category_id')});
       }
    }),
    init(){
        this._super(...arguments);
        var category_id = this.get('category_id');
        //var videos = this.get('store').query('video', {category: category_id});
        //this.set('videos', this.get('store').query('video', {category: category_id}));
    }
});