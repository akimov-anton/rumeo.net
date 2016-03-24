import Ember from 'ember';
import config from './config/environment';

const Router = Ember.Router.extend({
  location: config.locationType
});

Router.map(function() {
  this.route('index', {path: '/'}, function(){
    this.route('login');
  });
  this.route('add');
  this.route('videos', function() {
  });
  this.route('video', {path: 'videos/:id'}, function() {
    this.route('edit');
  });
  this.route('categories');
  //this.route('login');
});

export default Router;
