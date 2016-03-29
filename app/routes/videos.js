import Ember from 'ember';

export default Ember.Route.extend({
    queryParams: {
        category: {
            refreshModel: true
        }
    },
    model(params, transition){
        var queryParams = transition.queryParams;
        var category;
        if(queryParams.category){
            category = this.store.findRecord('video-category', queryParams.category);
        }
        var videos = this.store.query('video', {category: queryParams.category, limit: 15});
        return {
            category: category,
            videos: videos
        }
    }
});
