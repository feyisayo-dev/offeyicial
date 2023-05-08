(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? factory(exports, require('rxjs-es/Observable'), require('rxjs-es/Subscription'), require('virtual-dom/h'), require('virtual-dom/diff'), require('virtual-dom/patch'), require('virtual-dom/create-element'), require('element-closest'), require('rxjs-es/add/observable/of'), require('rxjs-es/add/observable/fromEvent'), require('rxjs-es/add/operator/share'), require('rxjs-es/BehaviorSubject')) :
    typeof define === 'function' && define.amd ? define(['exports', 'rxjs-es/Observable', 'rxjs-es/Subscription', 'virtual-dom/h', 'virtual-dom/diff', 'virtual-dom/patch', 'virtual-dom/create-element', 'element-closest', 'rxjs-es/add/observable/of', 'rxjs-es/add/observable/fromEvent', 'rxjs-es/add/operator/share', 'rxjs-es/BehaviorSubject'], factory) :
    (factory((global.uturn = global.uturn || {}),global.rxjsEs_Observable,global.rxjsEs_Subscription,global.h,global.diff,global.patch,global.createElement,global.elementClosest,global.rxjsEs_add_observable_of,global.rxjsEs_add_observable_fromEvent,global.rxjsEs_add_operator_share,global.rxjsEs_BehaviorSubject));
  }(this, function (exports,rxjsEs_Observable,rxjsEs_Subscription,h,diff,patch,createElement,elementClosest,rxjsEs_add_observable_of,rxjsEs_add_observable_fromEvent,rxjsEs_add_operator_share,rxjsEs_BehaviorSubject) { 'use strict';
  
    h = 'default' in h ? h['default'] : h;
    diff = 'default' in diff ? diff['default'] : diff;
    patch = 'default' in patch ? patch['default'] : patch;
    createElement = 'default' in createElement ? createElement['default'] : createElement;
  
    rxjsEs_Subscription.Subscription.prototype.with = function (subscription) {
      subscription.add(this);
      return this;
    };
  
    var classCallCheck = function (instance, Constructor) {
      if (!(instance instanceof Constructor)) {
        throw new TypeError("Cannot call a class as a function");
      }
    };
  
    var createClass = function () {
      function defineProperties(target, props) {
        for (var i = 0; i < props.length; i++) {
          var descriptor = props[i];
          descriptor.enumerable = descriptor.enumerable || false;
          descriptor.configurable = true;
          if ("value" in descriptor) descriptor.writable = true;
          Object.defineProperty(target, descriptor.key, descriptor);
        }
      }
  
      return function (Constructor, protoProps, staticProps) {
        if (protoProps) defineProperties(Constructor.prototype, protoProps);
        if (staticProps) defineProperties(Constructor, staticProps);
        return Constructor;
      };
    }();
  
    var get = function get(object, property, receiver) {
      if (object === null) object = Function.prototype;
      var desc = Object.getOwnPropertyDescriptor(object, property);
  
      if (desc === undefined) {
        var parent = Object.getPrototypeOf(object);
  
        if (parent === null) {
          return undefined;
        } else {
          return get(parent, property, receiver);
        }
      } else if ("value" in desc) {
        return desc.value;
      } else {
        var getter = desc.get;
  
        if (getter === undefined) {
          return undefined;
        }
  
        return getter.call(receiver);
      }
    };
  
    var inherits = function (subClass, superClass) {
      if (typeof superClass !== "function" && superClass !== null) {
        throw new TypeError("Super expression must either be null or a function, not " + typeof superClass);
      }
  
      subClass.prototype = Object.create(superClass && superClass.prototype, {
        constructor: {
          value: subClass,
          enumerable: false,
          writable: true,
          configurable: true
        }
      });
      if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass;
    };
  
    var possibleConstructorReturn = function (self, call) {
      if (!self) {
        throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
      }
  
      return call && (typeof call === "object" || typeof call === "function") ? call : self;
    };
  
    var DOMComponent = function () {
      function DOMComponent(el) {
        classCallCheck(this, DOMComponent);
  
        this.el = el;
        this.children = [];
        this.events = {};
        this.subscription = new rxjsEs_Subscription.Subscription();
      }
  
      createClass(DOMComponent, [{
        key: 'addChild',
        value: function addChild(child) {
          this.children.push(child);
          child.parent = this;
          child.didMoveToParent && child.didMoveToParent(this);
        }
      }, {
        key: 'on',
        value: function on(eventName, selector) {
          if (!this.events[eventName]) {
            this.events[eventName] = rxjsEs_Observable.Observable.fromEvent(this.el, eventName).share();
          }
  
          if (selector) {
            return this.events[eventName].filter(function (e) {
              var el = e.target;
              if (typeof selector === 'string') {
                return el.closest(selector);
              } else {
                return el === selector;
              }
            });
          } else {
            return this.events[eventName];
          }
        }
      }, {
        key: 'dispose',
        value: function dispose() {
          this.children.forEach(function (child) {
            if (child.dispose) {
              child.dispose();
              child.parent = null;
            }
          });
          this.children = null;
  
          if (this.vm) {
            this.vm.unsubscribe();
            this.vm = null;
          }
          this.subscription.unsubscribe();
          this.subscription = null;
        }
      }]);
      return DOMComponent;
    }();
  
    var VirtualDOMComponent = function (_DOMComponent) {
      inherits(VirtualDOMComponent, _DOMComponent);
  
      function VirtualDOMComponent() {
        classCallCheck(this, VirtualDOMComponent);
        return possibleConstructorReturn(this, Object.getPrototypeOf(VirtualDOMComponent).apply(this, arguments));
      }
  
      createClass(VirtualDOMComponent, [{
        key: 'bindDOM',
        value: function bindDOM(bindElement) {
          var _this2 = this;
  
          var tree = null;
          var node = null;
  
          this.renderSubscription = this.render().subscribe(function (newTree) {
            if (tree) {
              var patches = diff(tree, newTree);
              node = patch(node, patches);
              tree = newTree;
            } else {
              tree = newTree;
              node = createElement(tree, { document: window.document });
              var el = bindElement || _this2.el;
              el.innerText = '';
              el.appendChild(node);
            }
          });
        }
      }, {
        key: 'unbindDOM',
        value: function unbindDOM() {
          if (this.renderSubscriptino) {
            this.renderSubscription.unsubscribe();
            this.renderSubscription = null;
          }
        }
      }, {
        key: 'render',
        value: function render() {
          return rxjsEs_Observable.Observable.of(h('div'));
        }
      }, {
        key: 'dispose',
        value: function dispose() {
          get(Object.getPrototypeOf(VirtualDOMComponent.prototype), 'dispose', this).call(this);
          this.unbindDOM();
        }
      }]);
      return VirtualDOMComponent;
    }(DOMComponent);
  
    var Variable = function () {
      function Variable(value, source) {
        var _this = this;
  
        classCallCheck(this, Variable);
  
        this.subject = new rxjsEs_BehaviorSubject.BehaviorSubject(value);
        if (source) {
          this.sourceDisposable = source.subscribe(function (v) {
            return _this.value = v;
          });
        }
      }
  
      createClass(Variable, [{
        key: 'next',
        value: function next(value) {
          this.subject.next(value);
        }
      }, {
        key: 'error',
        value: function error(_error) {
          this.subject.error(_error);
        }
      }, {
        key: 'complete',
        value: function complete() {
          this.subject.complete();
        }
      }, {
        key: 'unsubscribe',
        value: function unsubscribe() {
          if (this.sourceDisposable) {
            this.sourceDisposable.unsubscribe();
          }
          this.subject.complete();
        }
      }, {
        key: 'value',
        get: function get() {
          return this.subject.value;
        },
        set: function set(newValue) {
          this.subject.next(newValue);
        }
      }, {
        key: 'isUnsubscribed',
        get: function get() {
          return this.subject.isUnsubscribed;
        }
      }, {
        key: 'observable',
        get: function get() {
          return this.subject;
        }
      }]);
      return Variable;
    }();
  
    function toVariable(initialValue) {
      return new Variable(initialValue, this);
    }
  
    rxjsEs_Observable.Observable.prototype.toVariable = toVariable;
  
    var ViewModel = function () {
      function ViewModel() {
        var attrs = arguments.length <= 0 || arguments[0] === undefined ? {} : arguments[0];
        classCallCheck(this, ViewModel);
  
        this.keys = Object.keys(attrs);
        for (var key in attrs) {
          this[key] = new Variable(attrs[key]);
        }
      }
  
      createClass(ViewModel, [{
        key: 'unsubscribe',
        value: function unsubscribe() {
          for (var k in this) {
            if (this.hasOwnProperty(k)) {
              if (typeof this[k].dispose === 'function') {
                this[k].unsubscribe();
              }
            }
          }
        }
      }]);
      return ViewModel;
    }();
  
    exports.DOMComponent = DOMComponent;
    exports.VirtualDOMComponent = VirtualDOMComponent;
    exports.ViewModel = ViewModel;
    exports.Variable = Variable;
  
    Object.defineProperty(exports, '__esModule', { value: true });
  
  }));
  //# sourceMappingURL=index.umd.js.map