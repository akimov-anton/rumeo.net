export default Ember.Helper.helper(function (params) {
    var video_src = params[0];
    if(video_src){
        var hash = /(embed\/)(.{11})/.exec(video_src)[2];
        return `http://img.youtube.com/vi/${hash}/0.jpg`;
    }
});