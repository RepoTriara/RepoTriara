/*1.5.7*/
(function () {
    var f = 0,
        l = [],
        n = {},
        j = {},
        a = { "<": "lt", ">": "gt", "&": "amp", '"': "quot", "'": "#39" },
        m = /[<>&\"\']/g,
        b,
        c = window.setTimeout,
        d = {},
        e;
    function h() {
        this.returnValue = false;
    }
    function k() {
        this.cancelBubble = true;
    }
    (function (o) {
        var p = o.split(/,/),
            q,
            s,
            r;
        for (q = 0; q < p.length; q += 2) {
            r = p[q + 1].split(/ /);
            for (s = 0; s < r.length; s++) {
                j[r[s]] = p[q];
            }
        }
    })(
        "application/msword,doc dot,application/pdf,pdf,application/pgp-signature,pgp,application/postscript,ps ai eps,application/rtf,rtf,application/vnd.ms-excel,xls xlb,application/vnd.ms-powerpoint,ppt pps pot,application/zip,zip,application/x-shockwave-flash,swf swfl,application/vnd.openxmlformats-officedocument.wordprocessingml.document,docx,application/vnd.openxmlformats-officedocument.wordprocessingml.template,dotx,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,xlsx,application/vnd.openxmlformats-officedocument.presentationml.presentation,pptx,application/vnd.openxmlformats-officedocument.presentationml.template,potx,application/vnd.openxmlformats-officedocument.presentationml.slideshow,ppsx,application/x-javascript,js,application/json,json,audio/mpeg,mpga mpega mp2 mp3,audio/x-wav,wav,audio/mp4,m4a,image/bmp,bmp,image/gif,gif,image/jpeg,jpeg jpg jpe,image/photoshop,psd,image/png,png,image/svg+xml,svg svgz,image/tiff,tiff tif,text/plain,asc txt text diff log,text/html,htm html xhtml,text/css,css,text/csv,csv,text/rtf,rtf,video/mpeg,mpeg mpg mpe m2v,video/quicktime,qt mov,video/mp4,mp4,video/x-m4v,m4v,video/x-flv,flv,video/x-ms-wmv,wmv,video/avi,avi,video/webm,webm,video/3gpp,3gp,video/3gpp2,3g2,video/vnd.rn-realvideo,rv,application/vnd.oasis.opendocument.formula-template,otf,application/octet-stream,exe"
    );
    var g = {
        VERSION: "1.5.7",
        STOPPED: 1,
        STARTED: 2,
        QUEUED: 1,
        UPLOADING: 2,
        FAILED: 4,
        DONE: 5,
        GENERIC_ERROR: -100,
        HTTP_ERROR: -200,
        IO_ERROR: -300,
        SECURITY_ERROR: -400,
        INIT_ERROR: -500,
        FILE_SIZE_ERROR: -600,
        FILE_EXTENSION_ERROR: -601,
        IMAGE_FORMAT_ERROR: -700,
        IMAGE_MEMORY_ERROR: -701,
        IMAGE_DIMENSIONS_ERROR: -702,
        mimeTypes: j,
        ua: (function () {
            var s = navigator,
                r = s.userAgent,
                t = s.vendor,
                p,
                o,
                q;
            p = /WebKit/.test(r);
            q = p && t.indexOf("Apple") !== -1;
            o = window.opera && window.opera.buildNumber;
            return {
                windows: navigator.platform.indexOf("Win") !== -1,
                android: /Android/.test(r),
                ie:
                    !p &&
                    !o &&
                    /MSIE/gi.test(r) &&
                    /Explorer/gi.test(s.appName),
                webkit: p,
                gecko: !p && /Gecko/.test(r),
                safari: q,
                opera: !!o,
            };
        })(),
        typeOf: function (p) {
            return {}.toString
                .call(p)
                .match(/\s([a-z|A-Z]+)/)[1]
                .toLowerCase();
        },
        extend: function (o) {
            g.each(arguments, function (p, q) {
                if (q > 0) {
                    g.each(p, function (s, r) {
                        o[r] = s;
                    });
                }
            });
            return o;
        },
        cleanName: function (o) {
            var p, q;
            q = [
                /[\300-\306]/g,
                "A",
                /[\340-\346]/g,
                "a",
                /\307/g,
                "C",
                /\347/g,
                "c",
                /[\310-\313]/g,
                "E",
                /[\350-\353]/g,
                "e",
                /[\314-\317]/g,
                "I",
                /[\354-\357]/g,
                "i",
                /\321/g,
                "N",
                /\361/g,
                "n",
                /[\322-\330]/g,
                "O",
                /[\362-\370]/g,
                "o",
                /[\331-\334]/g,
                "U",
                /[\371-\374]/g,
                "u",
            ];
            for (p = 0; p < q.length; p += 2) {
                o = o.replace(q[p], q[p + 1]);
            }
            o = o.replace(/\s+/g, "_");
            o = o.replace(/[^a-z0-9_\-\.]+/gi, "");
            return o;
        },
        addRuntime: function (o, p) {
            p.name = o;
            l[o] = p;
            l.push(p);
            return p;
        },
        guid: function () {
            var o = new Date().getTime().toString(32),
                p;
            for (p = 0; p < 5; p++) {
                o += Math.floor(Math.random() * 65535).toString(32);
            }
            return (g.guidPrefix || "p") + o + (f++).toString(32);
        },
        buildUrl: function (p, o) {
            var q = "";
            g.each(o, function (s, r) {
                q +=
                    (q ? "&" : "") +
                    encodeURIComponent(r) +
                    "=" +
                    encodeURIComponent(s);
            });
            if (q) {
                p += (p.indexOf("?") > 0 ? "&" : "?") + q;
            }
            return p;
        },
        each: function (r, s) {
            var q, p, o;
            if (r) {
                q = r.length;
                if (q === b) {
                    for (p in r) {
                        if (r.hasOwnProperty(p)) {
                            if (s(r[p], p) === false) {
                                return;
                            }
                        }
                    }
                } else {
                    for (o = 0; o < q; o++) {
                        if (s(r[o], o) === false) {
                            return;
                        }
                    }
                }
            }
        },
        formatSize: function (o) {
            if (o === b || /\D/.test(o)) {
                return g.translate("N/A");
            }
            if (o > 1073741824) {
                return Math.round(o / 1073741824, 1) + " GB";
            }
            if (o > 1048576) {
                return Math.round(o / 1048576, 1) + " MB";
            }
            if (o > 1024) {
                return Math.round(o / 1024, 1) + " KB";
            }
            return o + " b";
        },
        getPos: function (p, t) {
            var u = 0,
                s = 0,
                w,
                v = document,
                q,
                r;
            p = p;
            t = t || v.body;
            function o(C) {
                var A,
                    B,
                    z = 0,
                    D = 0;
                if (C) {
                    B = C.getBoundingClientRect();
                    A =
                        v.compatMode === "CSS1Compat"
                            ? v.documentElement
                            : v.body;
                    z = B.left + A.scrollLeft;
                    D = B.top + A.scrollTop;
                }
                return { x: z, y: D };
            }
            if (
                p &&
                p.getBoundingClientRect &&
                g.ua.ie &&
                (!v.documentMode || v.documentMode < 8)
            ) {
                q = o(p);
                r = o(t);
                return { x: q.x - r.x, y: q.y - r.y };
            }
            w = p;
            while (w && w != t && w.nodeType) {
                u += w.offsetLeft || 0;
                s += w.offsetTop || 0;
                w = w.offsetParent;
            }
            w = p.parentNode;
            while (w && w != t && w.nodeType) {
                u -= w.scrollLeft || 0;
                s -= w.scrollTop || 0;
                w = w.parentNode;
            }
            return { x: u, y: s };
        },
        getSize: function (o) {
            return {
                w: o.offsetWidth || o.clientWidth,
                h: o.offsetHeight || o.clientHeight,
            };
        },
        parseSize: function (o) {
            var p;
            if (typeof o == "string") {
                o = /^([0-9]+)([mgk]?)$/.exec(
                    o.toLowerCase().replace(/[^0-9mkg]/g, "")
                );
                p = o[2];
                o = +o[1];
                if (p == "g") {
                    o *= 1073741824;
                }
                if (p == "m") {
                    o *= 1048576;
                }
                if (p == "k") {
                    o *= 1024;
                }
            }
            return o;
        },
        xmlEncode: function (o) {
            return o
                ? ("" + o).replace(m, function (p) {
                      return a[p] ? "&" + a[p] + ";" : p;
                  })
                : o;
        },
        toArray: function (q) {
            var p,
                o = [];
            for (p = 0; p < q.length; p++) {
                o[p] = q[p];
            }
            return o;
        },
        inArray: function (q, r) {
            if (r) {
                if (Array.prototype.indexOf) {
                    return Array.prototype.indexOf.call(r, q);
                }
                for (var o = 0, p = r.length; o < p; o++) {
                    if (r[o] === q) {
                        return o;
                    }
                }
            }
            return -1;
        },
        addI18n: function (o) {
            return g.extend(n, o);
        },
        translate: function (o) {
            return n[o] || o;
        },
        isEmptyObj: function (o) {
            if (o === b) {
                return true;
            }
            for (var p in o) {
                return false;
            }
            return true;
        },
        hasClass: function (q, p) {
            var o;
            if (q.className == "") {
                return false;
            }
            o = new RegExp("(^|\\s+)" + p + "(\\s+|$)");
            return o.test(q.className);
        },
        addClass: function (p, o) {
            if (!g.hasClass(p, o)) {
                p.className =
                    p.className == ""
                        ? o
                        : p.className.replace(/\s+$/, "") + " " + o;
            }
        },
        removeClass: function (q, p) {
            var o = new RegExp("(^|\\s+)" + p + "(\\s+|$)");
            q.className = q.className.replace(o, function (s, r, t) {
                return r === " " && t === " " ? " " : "";
            });
        },
        getStyle: function (p, o) {
            if (p.currentStyle) {
                return p.currentStyle[o];
            } else {
                if (window.getComputedStyle) {
                    return window.getComputedStyle(p, null)[o];
                }
            }
        },
        addEvent: function (t, o, u) {
            var s, r, q, p;
            p = arguments[3];
            o = o.toLowerCase();
            if (e === b) {
                e = "Plupload_" + g.guid();
            }
            if (t.addEventListener) {
                s = u;
                t.addEventListener(o, s, false);
            } else {
                if (t.attachEvent) {
                    s = function () {
                        var v = window.event;
                        if (!v.target) {
                            v.target = v.srcElement;
                        }
                        v.preventDefault = h;
                        v.stopPropagation = k;
                        u(v);
                    };
                    t.attachEvent("on" + o, s);
                }
            }
            if (t[e] === b) {
                t[e] = g.guid();
            }
            if (!d.hasOwnProperty(t[e])) {
                d[t[e]] = {};
            }
            r = d[t[e]];
            if (!r.hasOwnProperty(o)) {
                r[o] = [];
            }
            r[o].push({ func: s, orig: u, key: p });
        },
        removeEvent: function (t, o) {
            var r, u, q;
            if (typeof arguments[2] == "function") {
                u = arguments[2];
            } else {
                q = arguments[2];
            }
            o = o.toLowerCase();
            if (t[e] && d[t[e]] && d[t[e]][o]) {
                r = d[t[e]][o];
            } else {
                return;
            }
            for (var p = r.length - 1; p >= 0; p--) {
                if (r[p].key === q || r[p].orig === u) {
                    if (t.removeEventListener) {
                        t.removeEventListener(o, r[p].func, false);
                    } else {
                        if (t.detachEvent) {
                            t.detachEvent("on" + o, r[p].func);
                        }
                    }
                    r[p].orig = null;
                    r[p].func = null;
                    r.splice(p, 1);
                    if (u !== b) {
                        break;
                    }
                }
            }
            if (!r.length) {
                delete d[t[e]][o];
            }
            if (g.isEmptyObj(d[t[e]])) {
                delete d[t[e]];
                try {
                    delete t[e];
                } catch (s) {
                    t[e] = b;
                }
            }
        },
        removeAllEvents: function (p) {
            var o = arguments[1];
            if (p[e] === b || !p[e]) {
                return;
            }
            g.each(d[p[e]], function (r, q) {
                g.removeEvent(p, q, o);
            });
        },
    };
    g.Uploader = function (s) {
        var p = {},
            v,
            u = [],
            r,
            q = false;
        v = new g.QueueProgress();
        s = g.extend(
            {
                chunk_size: 0,
                multipart: true,
                multi_selection: true,
                file_data_name: "file",
                filters: [],
            },
            s
        );
        function t() {
            var x,
                y = 0,
                w;
            if (this.state == g.STARTED) {
                for (w = 0; w < u.length; w++) {
                    if (!x && u[w].status == g.QUEUED) {
                        x = u[w];
                        x.status = g.UPLOADING;
                        if (this.trigger("BeforeUpload", x)) {
                            this.trigger("UploadFile", x);
                        }
                    } else {
                        y++;
                    }
                }
                if (y == u.length) {
                    this.stop();
                    this.trigger("UploadComplete", u);
                }
            }
        }
        function o() {
            var x, w;
            v.reset();
            for (x = 0; x < u.length; x++) {
                w = u[x];
                if (w.size !== b) {
                    v.size += w.size;
                    v.loaded += w.loaded;
                } else {
                    v.size = b;
                }
                if (w.status == g.DONE) {
                    v.uploaded++;
                } else {
                    if (w.status == g.FAILED) {
                        v.failed++;
                    } else {
                        v.queued++;
                    }
                }
            }
            if (v.size === b) {
                v.percent =
                    u.length > 0 ? Math.ceil((v.uploaded / u.length) * 100) : 0;
            } else {
                v.bytesPerSec = Math.ceil(
                    v.loaded / ((+new Date() - r || 1) / 1000)
                );
                v.percent =
                    v.size > 0 ? Math.ceil((v.loaded / v.size) * 100) : 0;
            }
        }
        g.extend(this, {
            state: g.STOPPED,
            runtime: "",
            features: {},
            files: u,
            settings: s,
            total: v,
            id: g.guid(),
            init: function () {
                var B = this,
                    C,
                    y,
                    x,
                    A = 0,
                    z;
                if (typeof s.preinit == "function") {
                    s.preinit(B);
                } else {
                    g.each(s.preinit, function (E, D) {
                        B.bind(D, E);
                    });
                }
                s.page_url =
                    s.page_url ||
                    document.location.pathname.replace(/\/[^\/]+$/g, "/");
                if (!/^(\w+:\/\/|\/)/.test(s.url)) {
                    s.url = s.page_url + s.url;
                }
                s.chunk_size = g.parseSize(s.chunk_size);
                s.max_file_size = g.parseSize(s.max_file_size);
                B.bind("FilesAdded", function (D, G) {
                    var F,
                        E,
                        I = 0,
                        J,
                        H = s.filters;
                    if (H && H.length) {
                        J = [];
                        g.each(H, function (K) {
                            g.each(K.extensions.split(/,/), function (L) {
                                if (/^\s*\*\s*$/.test(L)) {
                                    J.push("\\.*");
                                } else {
                                    J.push(
                                        "\\." +
                                            L.replace(
                                                new RegExp(
                                                    "[" +
                                                        "/^$.*+?|()[]{}\\".replace(
                                                            /./g,
                                                            "\\$&"
                                                        ) +
                                                        "]",
                                                    "g"
                                                ),
                                                "\\$&"
                                            )
                                    );
                                }
                            });
                        });
                        J = new RegExp(J.join("|") + "$", "i");
                    }
                    for (F = 0; F < G.length; F++) {
                        E = G[F];
                        E.loaded = 0;
                        E.percent = 0;
                        E.status = g.QUEUED;
                        if (J && !J.test(E.name)) {
                            D.trigger("Error", {
                                code: g.FILE_EXTENSION_ERROR,
                                message: g.translate("File extension error."),
                                file: E,
                            });
                            continue;
                        }
                        if (E.size !== b && E.size > s.max_file_size) {
                            D.trigger("Error", {
                                code: g.FILE_SIZE_ERROR,
                                message: g.translate("File size error."),
                                file: E,
                            });
                            continue;
                        }
                        u.push(E);
                        I++;
                    }
                    if (I) {
                        c(function () {
                            B.trigger("QueueChanged");
                            B.refresh();
                        }, 1);
                    } else {
                        return false;
                    }
                });
                if (s.unique_names) {
                    B.bind("UploadFile", function (D, E) {
                        var G = E.name.match(/\.([^.]+)$/),
                            F = "tmp";
                        if (G) {
                            F = G[1];
                        }
                        E.target_name = E.id + "." + F;
                    });
                }
                B.bind("UploadProgress", function (D, E) {
                    E.percent =
                        E.size > 0 ? Math.ceil((E.loaded / E.size) * 100) : 100;
                    o();
                });
                B.bind("StateChanged", function (D) {
                    if (D.state == g.STARTED) {
                        r = +new Date();
                    } else {
                        if (D.state == g.STOPPED) {
                            for (C = D.files.length - 1; C >= 0; C--) {
                                if (D.files[C].status == g.UPLOADING) {
                                    D.files[C].status = g.QUEUED;
                                    o();
                                }
                            }
                        }
                    }
                });
                B.bind("QueueChanged", o);
                B.bind("Error", function (D, E) {
                    if (E.file) {
                        E.file.status = g.FAILED;
                        o();
                        if (D.state == g.STARTED) {
                            c(function () {
                                t.call(B);
                            }, 1);
                        }
                    }
                });
                B.bind("FileUploaded", function (D, E) {
                    E.status = g.DONE;
                    E.loaded = E.size;
                    D.trigger("UploadProgress", E);
                    c(function () {
                        t.call(B);
                    }, 1);
                });
                if (s.runtimes) {
                    y = [];
                    z = s.runtimes.split(/\s?,\s?/);
                    for (C = 0; C < z.length; C++) {
                        if (l[z[C]]) {
                            y.push(l[z[C]]);
                        }
                    }
                } else {
                    y = l;
                }
                function w() {
                    var G = y[A++],
                        F,
                        D,
                        E;
                    if (G) {
                        F = G.getFeatures();
                        D = B.settings.required_features;
                        if (D) {
                            D = D.split(",");
                            for (E = 0; E < D.length; E++) {
                                if (!F[D[E]]) {
                                    w();
                                    return;
                                }
                            }
                        }
                        G.init(B, function (H) {
                            if (H && H.success) {
                                B.features = F;
                                B.runtime = G.name;
                                B.trigger("Init", { runtime: G.name });
                                B.trigger("PostInit");
                                B.refresh();
                            } else {
                                w();
                            }
                        });
                    } else {
                        B.trigger("Error", {
                            code: g.INIT_ERROR,
                            message: g.translate("Init error."),
                        });
                    }
                }
                w();
                if (typeof s.init == "function") {
                    s.init(B);
                } else {
                    g.each(s.init, function (E, D) {
                        B.bind(D, E);
                    });
                }
            },
            refresh: function () {
                this.trigger("Refresh");
            },
            start: function () {
                if (u.length && this.state != g.STARTED) {
                    this.state = g.STARTED;
                    this.trigger("StateChanged");
                    t.call(this);
                }
            },
            stop: function () {
                if (this.state != g.STOPPED) {
                    this.state = g.STOPPED;
                    this.trigger("CancelUpload");
                    this.trigger("StateChanged");
                }
            },
            disableBrowse: function () {
                q = arguments[0] !== b ? arguments[0] : true;
                this.trigger("DisableBrowse", q);
            },
            getFile: function (x) {
                var w;
                for (w = u.length - 1; w >= 0; w--) {
                    if (u[w].id === x) {
                        return u[w];
                    }
                }
            },
            removeFile: function (x) {
                var w;
                for (w = u.length - 1; w >= 0; w--) {
                    if (u[w].id === x.id) {
                        return this.splice(w, 1)[0];
                    }
                }
            },
            splice: function (y, w) {
                var x;
                x = u.splice(y === b ? 0 : y, w === b ? u.length : w);
                this.trigger("FilesRemoved", x);
                this.trigger("QueueChanged");
                return x;
            },
            trigger: function (x) {
                var z = p[x.toLowerCase()],
                    y,
                    w;
                if (z) {
                    w = Array.prototype.slice.call(arguments);
                    w[0] = this;
                    for (y = 0; y < z.length; y++) {
                        if (z[y].func.apply(z[y].scope, w) === false) {
                            return false;
                        }
                    }
                }
                return true;
            },
            hasEventListener: function (w) {
                return !!p[w.toLowerCase()];
            },
            bind: function (w, y, x) {
                var z;
                w = w.toLowerCase();
                z = p[w] || [];
                z.push({ func: y, scope: x || this });
                p[w] = z;
            },
            unbind: function (w) {
                w = w.toLowerCase();
                var z = p[w],
                    x,
                    y = arguments[1];
                if (z) {
                    if (y !== b) {
                        for (x = z.length - 1; x >= 0; x--) {
                            if (z[x].func === y) {
                                z.splice(x, 1);
                                break;
                            }
                        }
                    } else {
                        z = [];
                    }
                    if (!z.length) {
                        delete p[w];
                    }
                }
            },
            unbindAll: function () {
                var w = this;
                g.each(p, function (y, x) {
                    w.unbind(x);
                });
            },
            destroy: function () {
                this.stop();
                this.trigger("Destroy");
                this.unbindAll();
            },
        });
    };
    g.File = function (r, p, q) {
        var o = this;
        o.id = r;
        o.name = p;
        o.size = q;
        o.loaded = 0;
        o.percent = 0;
        o.status = 0;
    };
    g.Runtime = function () {
        this.getFeatures = function () {};
        this.init = function (o, p) {};
    };
    g.QueueProgress = function () {
        var o = this;
        o.size = 0;
        o.loaded = 0;
        o.uploaded = 0;
        o.failed = 0;
        o.queued = 0;
        o.percent = 0;
        o.bytesPerSec = 0;
        o.reset = function () {
            o.size =
                o.loaded =
                o.uploaded =
                o.failed =
                o.queued =
                o.percent =
                o.bytesPerSec =
                    0;
        };
    };
    g.runtimes = {};
    window.plupload = g;
})();
(function () {
    if (window.google && google.gears) {
        return;
    }
    var a = null;
    if (typeof GearsFactory != "undefined") {
        a = new GearsFactory();
    } else {
        try {
            a = new ActiveXObject("Gears.Factory");
            if (a.getBuildInfo().indexOf("ie_mobile") != -1) {
                a.privateSetGlobalObject(this);
            }
        } catch (b) {
            if (
                typeof navigator.mimeTypes != "undefined" &&
                navigator.mimeTypes["application/x-googlegears"]
            ) {
                a = document.createElement("object");
                a.style.display = "none";
                a.width = 0;
                a.height = 0;
                a.type = "application/x-googlegears";
                document.documentElement.appendChild(a);
            }
        }
    }
    if (!a) {
        return;
    }
    if (!window.google) {
        window.google = {};
    }
    if (!google.gears) {
        google.gears = { factory: a };
    }
})();
(function (e, b, c, d) {
    var f = {};
    function a(h, k, m) {
        var g, j, l, o;
        j = google.gears.factory.create("beta.canvas");
        try {
            j.decode(h);
            if (!k.width) {
                k.width = j.width;
            }
            if (!k.height) {
                k.height = j.height;
            }
            o = Math.min(k.width / j.width, k.height / j.height);
            if (o < 1) {
                j.resize(Math.round(j.width * o), Math.round(j.height * o));
            } else {
                if (!k.quality || m !== "image/jpeg") {
                    return h;
                }
            }
            if (k.quality) {
                return j.encode(m, { quality: k.quality / 100 });
            }
            return j.encode(m);
        } catch (n) {}
        return h;
    }
    c.runtimes.Gears = c.addRuntime("gears", {
        getFeatures: function () {
            return {
                dragdrop: true,
                jpgresize: true,
                pngresize: true,
                chunks: true,
                progress: true,
                multipart: true,
                multi_selection: true,
            };
        },
        init: function (l, n) {
            var m,
                h,
                g = false;
            if (!e.google || !google.gears) {
                return n({ success: false });
            }
            try {
                m = google.gears.factory.create("beta.desktop");
            } catch (k) {
                return n({ success: false });
            }
            function j(q) {
                var p,
                    o,
                    r = [],
                    s;
                for (o = 0; o < q.length; o++) {
                    p = q[o];
                    s = c.guid();
                    f[s] = p.blob;
                    r.push(new c.File(s, p.name, p.blob.length));
                }
                l.trigger("FilesAdded", r);
            }
            l.bind("PostInit", function () {
                var p = l.settings,
                    o = b.getElementById(p.drop_element);
                if (o) {
                    c.addEvent(
                        o,
                        "dragover",
                        function (q) {
                            m.setDropEffect(q, "copy");
                            q.preventDefault();
                        },
                        l.id
                    );
                    c.addEvent(
                        o,
                        "drop",
                        function (r) {
                            var q = m.getDragData(
                                r,
                                "application/x-gears-files"
                            );
                            if (q) {
                                j(q.files);
                            }
                            r.preventDefault();
                        },
                        l.id
                    );
                    o = 0;
                }
                c.addEvent(
                    b.getElementById(p.browse_button),
                    "click",
                    function (u) {
                        var t = [],
                            r,
                            q,
                            s;
                        u.preventDefault();
                        if (g) {
                            return;
                        }
                        no_type_restriction: for (
                            r = 0;
                            r < p.filters.length;
                            r++
                        ) {
                            s = p.filters[r].extensions.split(",");
                            for (q = 0; q < s.length; q++) {
                                if (s[q] === "*") {
                                    t = [];
                                    break no_type_restriction;
                                }
                                t.push("." + s[q]);
                            }
                        }
                        m.openFiles(j, {
                            singleFile: !p.multi_selection,
                            filter: t,
                        });
                    },
                    l.id
                );
            });
            l.bind("CancelUpload", function () {
                if (h.abort) {
                    h.abort();
                }
            });
            l.bind("UploadFile", function (u, r) {
                var w = 0,
                    v,
                    s,
                    t = 0,
                    q = u.settings.resize,
                    o;
                if (q && /\.(png|jpg|jpeg)$/i.test(r.name)) {
                    f[r.id] = a(
                        f[r.id],
                        q,
                        /\.png$/i.test(r.name) ? "image/png" : "image/jpeg"
                    );
                }
                r.size = f[r.id].length;
                s = u.settings.chunk_size;
                o = s > 0;
                v = Math.ceil(r.size / s);
                if (!o) {
                    s = r.size;
                    v = 1;
                }
                function p() {
                    var C,
                        y = u.settings.multipart,
                        x = 0,
                        B = { name: r.target_name || r.name },
                        z = u.settings.url;
                    function A(E) {
                        var D,
                            J = "----pluploadboundary" + c.guid(),
                            G = "--",
                            I = "\r\n",
                            F,
                            H;
                        if (y) {
                            h.setRequestHeader(
                                "Content-Type",
                                "multipart/form-data; boundary=" + J
                            );
                            D = google.gears.factory.create("beta.blobbuilder");
                            c.each(
                                c.extend(B, u.settings.multipart_params),
                                function (L, K) {
                                    D.append(
                                        G +
                                            J +
                                            I +
                                            'Content-Disposition: form-data; name="' +
                                            K +
                                            '"' +
                                            I +
                                            I
                                    );
                                    D.append(L + I);
                                }
                            );
                            H =
                                c.mimeTypes[
                                    r.name
                                        .replace(/^.+\.([^.]+)/, "$1")
                                        .toLowerCase()
                                ] || "application/octet-stream";
                            D.append(
                                G +
                                    J +
                                    I +
                                    'Content-Disposition: form-data; name="' +
                                    u.settings.file_data_name +
                                    '"; filename="' +
                                    r.name +
                                    '"' +
                                    I +
                                    "Content-Type: " +
                                    H +
                                    I +
                                    I
                            );
                            D.append(E);
                            D.append(I + G + J + G + I);
                            F = D.getAsBlob();
                            x = F.length - E.length;
                            E = F;
                        }
                        h.send(E);
                    }
                    if (
                        r.status == c.DONE ||
                        r.status == c.FAILED ||
                        u.state == c.STOPPED
                    ) {
                        return;
                    }
                    if (o) {
                        B.chunk = w;
                        B.chunks = v;
                    }
                    C = Math.min(s, r.size - w * s);
                    if (!y) {
                        z = c.buildUrl(u.settings.url, B);
                    }
                    h = google.gears.factory.create("beta.httprequest");
                    h.open("POST", z);
                    if (!y) {
                        h.setRequestHeader(
                            "Content-Disposition",
                            'attachment; filename="' + r.name + '"'
                        );
                        h.setRequestHeader(
                            "Content-Type",
                            "application/octet-stream"
                        );
                    }
                    c.each(u.settings.headers, function (E, D) {
                        h.setRequestHeader(D, E);
                    });
                    h.upload.onprogress = function (D) {
                        r.loaded = t + D.loaded - x;
                        u.trigger("UploadProgress", r);
                    };
                    h.onreadystatechange = function () {
                        var D;
                        if (h.readyState == 4 && u.state !== c.STOPPED) {
                            if (h.status == 200) {
                                D = {
                                    chunk: w,
                                    chunks: v,
                                    response: h.responseText,
                                    status: h.status,
                                };
                                u.trigger("ChunkUploaded", r, D);
                                if (D.cancelled) {
                                    r.status = c.FAILED;
                                    return;
                                }
                                t += C;
                                if (++w >= v) {
                                    r.status = c.DONE;
                                    u.trigger("FileUploaded", r, {
                                        response: h.responseText,
                                        status: h.status,
                                    });
                                } else {
                                    p();
                                }
                            } else {
                                u.trigger("Error", {
                                    code: c.HTTP_ERROR,
                                    message: c.translate("HTTP Error."),
                                    file: r,
                                    chunk: w,
                                    chunks: v,
                                    status: h.status,
                                });
                            }
                        }
                    };
                    if (w < v) {
                        A(f[r.id].slice(w * s, C));
                    }
                }
                p();
            });
            l.bind("DisableBrowse", function (o, p) {
                g = p;
            });
            l.bind("Destroy", function (o) {
                var p,
                    q,
                    r = {
                        browseButton: o.settings.browse_button,
                        dropElm: o.settings.drop_element,
                    };
                for (p in r) {
                    q = b.getElementById(r[p]);
                    if (q) {
                        c.removeAllEvents(q, o.id);
                    }
                }
            });
            n({ success: true });
        },
    });
})(window, document, plupload);
(function (g, b, d, e) {
    var a = {},
        h = {};
    function c(o) {
        var n,
            m = typeof o,
            j,
            l,
            k;
        if (o === e || o === null) {
            return "null";
        }
        if (m === "string") {
            n = "\bb\tt\nn\ff\rr\"\"''\\\\";
            return (
                '"' +
                o.replace(/([\u0080-\uFFFF\x00-\x1f\"])/g, function (r, q) {
                    var p = n.indexOf(q);
                    if (p + 1) {
                        return "\\" + n.charAt(p + 1);
                    }
                    r = q.charCodeAt().toString(16);
                    return "\\u" + "0000".substring(r.length) + r;
                }) +
                '"'
            );
        }
        if (m == "object") {
            j = o.length !== e;
            n = "";
            if (j) {
                for (l = 0; l < o.length; l++) {
                    if (n) {
                        n += ",";
                    }
                    n += c(o[l]);
                }
                n = "[" + n + "]";
            } else {
                for (k in o) {
                    if (o.hasOwnProperty(k)) {
                        if (n) {
                            n += ",";
                        }
                        n += c(k) + ":" + c(o[k]);
                    }
                }
                n = "{" + n + "}";
            }
            return n;
        }
        return "" + o;
    }
    function f(s) {
        var v = false,
            j = null,
            o = null,
            k,
            l,
            m,
            u,
            n,
            q = 0;
        try {
            try {
                o = new ActiveXObject("AgControl.AgControl");
                if (o.IsVersionSupported(s)) {
                    v = true;
                }
                o = null;
            } catch (r) {
                var p = navigator.plugins["Silverlight Plug-In"];
                if (p) {
                    k = p.description;
                    if (k === "1.0.30226.2") {
                        k = "2.0.30226.2";
                    }
                    l = k.split(".");
                    while (l.length > 3) {
                        l.pop();
                    }
                    while (l.length < 4) {
                        l.push(0);
                    }
                    m = s.split(".");
                    while (m.length > 4) {
                        m.pop();
                    }
                    do {
                        u = parseInt(m[q], 10);
                        n = parseInt(l[q], 10);
                        q++;
                    } while (q < m.length && u === n);
                    if (u <= n && !isNaN(u)) {
                        v = true;
                    }
                }
            }
        } catch (t) {
            v = false;
        }
        return v;
    }
    d.silverlight = {
        trigger: function (n, k) {
            var m = a[n],
                l,
                j;
            if (m) {
                j = d.toArray(arguments).slice(1);
                j[0] = "Silverlight:" + k;
                setTimeout(function () {
                    m.trigger.apply(m, j);
                }, 0);
            }
        },
    };
    d.runtimes.Silverlight = d.addRuntime("silverlight", {
        getFeatures: function () {
            return {
                jpgresize: true,
                pngresize: true,
                chunks: true,
                progress: true,
                multipart: true,
                multi_selection: true,
            };
        },
        init: function (p, q) {
            var o,
                m = "",
                n = p.settings.filters,
                l,
                k = b.body;
            if (!f("2.0.31005.0") || (g.opera && g.opera.buildNumber)) {
                q({ success: false });
                return;
            }
            h[p.id] = false;
            a[p.id] = p;
            o = b.createElement("div");
            o.id = p.id + "_silverlight_container";
            d.extend(o.style, {
                position: "absolute",
                top: "0px",
                background: p.settings.shim_bgcolor || "transparent",
                zIndex: 99999,
                width: "100px",
                height: "100px",
                overflow: "hidden",
                opacity:
                    p.settings.shim_bgcolor || b.documentMode > 8 ? "" : 0.01,
            });
            o.className = "plupload silverlight";
            if (p.settings.container) {
                k = b.getElementById(p.settings.container);
                if (d.getStyle(k, "position") === "static") {
                    k.style.position = "relative";
                }
            }
            k.appendChild(o);
            for (l = 0; l < n.length; l++) {
                m +=
                    (m != "" ? "|" : "") +
                    n[l].title +
                    " | *." +
                    n[l].extensions.replace(/,/g, ";*.");
            }
            o.innerHTML =
                '<object id="' +
                p.id +
                '_silverlight" data="data:application/x-silverlight," type="application/x-silverlight-2" style="outline:none;" width="1024" height="1024"><param name="source" value="' +
                p.settings.silverlight_xap_url +
                '"/><param name="background" value="Transparent"/><param name="windowless" value="true"/><param name="enablehtmlaccess" value="true"/><param name="initParams" value="id=' +
                p.id +
                ",filter=" +
                m +
                ",multiselect=" +
                p.settings.multi_selection +
                '"/></object>';
            function j() {
                return b.getElementById(p.id + "_silverlight").content.Upload;
            }
            p.bind("Silverlight:Init", function () {
                var r,
                    s = {};
                if (h[p.id]) {
                    return;
                }
                h[p.id] = true;
                p.bind("Silverlight:StartSelectFiles", function (t) {
                    r = [];
                });
                p.bind("Silverlight:SelectFile", function (t, w, u, v) {
                    var x;
                    x = d.guid();
                    s[x] = w;
                    s[w] = x;
                    r.push(new d.File(x, u, v));
                });
                p.bind("Silverlight:SelectSuccessful", function () {
                    if (r.length) {
                        p.trigger("FilesAdded", r);
                    }
                });
                p.bind(
                    "Silverlight:UploadChunkError",
                    function (t, w, u, x, v) {
                        p.trigger("Error", {
                            code: d.IO_ERROR,
                            message: "IO Error.",
                            details: v,
                            file: t.getFile(s[w]),
                        });
                    }
                );
                p.bind("Silverlight:UploadFileProgress", function (t, x, u, w) {
                    var v = t.getFile(s[x]);
                    if (v.status != d.FAILED) {
                        v.size = w;
                        v.loaded = u;
                        t.trigger("UploadProgress", v);
                    }
                });
                p.bind("Refresh", function (t) {
                    var u, v, w;
                    u = b.getElementById(t.settings.browse_button);
                    if (u) {
                        v = d.getPos(u, b.getElementById(t.settings.container));
                        w = d.getSize(u);
                        d.extend(
                            b.getElementById(t.id + "_silverlight_container")
                                .style,
                            {
                                top: v.y + "px",
                                left: v.x + "px",
                                width: w.w + "px",
                                height: w.h + "px",
                            }
                        );
                    }
                });
                p.bind(
                    "Silverlight:UploadChunkSuccessful",
                    function (t, w, u, z, y) {
                        var x,
                            v = t.getFile(s[w]);
                        x = { chunk: u, chunks: z, response: y };
                        t.trigger("ChunkUploaded", v, x);
                        if (v.status != d.FAILED && t.state !== d.STOPPED) {
                            j().UploadNextChunk();
                        }
                        if (u == z - 1) {
                            v.status = d.DONE;
                            t.trigger("FileUploaded", v, { response: y });
                        }
                    }
                );
                p.bind("Silverlight:UploadSuccessful", function (t, w, u) {
                    var v = t.getFile(s[w]);
                    v.status = d.DONE;
                    t.trigger("FileUploaded", v, { response: u });
                });
                p.bind("FilesRemoved", function (t, v) {
                    var u;
                    for (u = 0; u < v.length; u++) {
                        j().RemoveFile(s[v[u].id]);
                    }
                });
                p.bind("UploadFile", function (t, v) {
                    var w = t.settings,
                        u = w.resize || {};
                    j().UploadFile(
                        s[v.id],
                        t.settings.url,
                        c({
                            name: v.target_name || v.name,
                            mime:
                                d.mimeTypes[
                                    v.name
                                        .replace(/^.+\.([^.]+)/, "$1")
                                        .toLowerCase()
                                ] || "application/octet-stream",
                            chunk_size: w.chunk_size,
                            image_width: u.width,
                            image_height: u.height,
                            image_quality: u.quality,
                            multipart: !!w.multipart,
                            multipart_params: w.multipart_params || {},
                            file_data_name: w.file_data_name,
                            headers: w.headers,
                        })
                    );
                });
                p.bind("CancelUpload", function () {
                    j().CancelUpload();
                });
                p.bind("Silverlight:MouseEnter", function (t) {
                    var u, v;
                    u = b.getElementById(p.settings.browse_button);
                    v = t.settings.browse_button_hover;
                    if (u && v) {
                        d.addClass(u, v);
                    }
                });
                p.bind("Silverlight:MouseLeave", function (t) {
                    var u, v;
                    u = b.getElementById(p.settings.browse_button);
                    v = t.settings.browse_button_hover;
                    if (u && v) {
                        d.removeClass(u, v);
                    }
                });
                p.bind("Silverlight:MouseLeftButtonDown", function (t) {
                    var u, v;
                    u = b.getElementById(p.settings.browse_button);
                    v = t.settings.browse_button_active;
                    if (u && v) {
                        d.addClass(u, v);
                        d.addEvent(b.body, "mouseup", function () {
                            d.removeClass(u, v);
                        });
                    }
                });
                p.bind("Sliverlight:StartSelectFiles", function (t) {
                    var u, v;
                    u = b.getElementById(p.settings.browse_button);
                    v = t.settings.browse_button_active;
                    if (u && v) {
                        d.removeClass(u, v);
                    }
                });
                p.bind("DisableBrowse", function (t, u) {
                    j().DisableBrowse(u);
                });
                p.bind("Destroy", function (t) {
                    var u;
                    d.removeAllEvents(b.body, t.id);
                    delete h[t.id];
                    delete a[t.id];
                    u = b.getElementById(t.id + "_silverlight_container");
                    if (u) {
                        u.parentNode.removeChild(u);
                    }
                });
                q({ success: true });
            });
        },
    });
})(window, document, plupload);
(function (f, b, d, e) {
    var a = {},
        g = {};
    function c() {
        var h;
        try {
            h = navigator.plugins["Shockwave Flash"];
            h = h.description;
        } catch (k) {
            try {
                h = new ActiveXObject(
                    "ShockwaveFlash.ShockwaveFlash"
                ).GetVariable("$version");
            } catch (j) {
                h = "0.0";
            }
        }
        h = h.match(/\d+/g);
        return parseFloat(h[0] + "." + h[1]);
    }
    d.flash = {
        trigger: function (k, h, j) {
            setTimeout(function () {
                var n = a[k],
                    m,
                    l;
                if (n) {
                    n.trigger("Flash:" + h, j);
                }
            }, 0);
        },
    };
    d.runtimes.Flash = d.addRuntime("flash", {
        getFeatures: function () {
            return {
                jpgresize: true,
                pngresize: true,
                maxWidth: 8091,
                maxHeight: 8091,
                chunks: true,
                progress: true,
                multipart: true,
                multi_selection: true,
            };
        },
        init: function (n, p) {
            var l,
                m,
                h = 0,
                j = b.body;
            if (c() < 10) {
                p({ success: false });
                return;
            }
            g[n.id] = false;
            a[n.id] = n;
            l = b.getElementById(n.settings.browse_button);
            m = b.createElement("div");
            m.id = n.id + "_flash_container";
            d.extend(m.style, {
                position: "absolute",
                top: "0px",
                background: n.settings.shim_bgcolor || "transparent",
                zIndex: 99999,
                width: "100%",
                height: "100%",
            });
            m.className = "plupload flash";
            if (n.settings.container) {
                j = b.getElementById(n.settings.container);
                if (d.getStyle(j, "position") === "static") {
                    j.style.position = "relative";
                }
            }
            j.appendChild(m);
            (function () {
                var q, r;
                q =
                    '<object id="' +
                    n.id +
                    '_flash" type="application/x-shockwave-flash" data="' +
                    n.settings.flash_swf_url +
                    '" ';
                if (d.ua.ie) {
                    q +=
                        'classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ';
                }
                q +=
                    'width="100%" height="100%" style="outline:0"><param name="movie" value="' +
                    n.settings.flash_swf_url +
                    '" /><param name="flashvars" value="id=' +
                    escape(n.id) +
                    '" /><param name="wmode" value="transparent" /><param name="allowscriptaccess" value="always" /></object>';
                if (d.ua.ie) {
                    r = b.createElement("div");
                    m.appendChild(r);
                    r.outerHTML = q;
                    r = null;
                } else {
                    m.innerHTML = q;
                }
            })();
            function o() {
                return b.getElementById(n.id + "_flash");
            }
            function k() {
                if (h++ > 5000) {
                    p({ success: false });
                    return;
                }
                if (g[n.id] === false) {
                    setTimeout(k, 1);
                }
            }
            k();
            l = m = null;
            n.bind("Destroy", function (q) {
                var r;
                d.removeAllEvents(b.body, q.id);
                delete g[q.id];
                delete a[q.id];
                r = b.getElementById(q.id + "_flash_container");
                if (r) {
                    r.parentNode.removeChild(r);
                }
            });
            n.bind("Flash:Init", function () {
                var s = {},
                    r;
                try {
                    o().setFileFilters(
                        n.settings.filters,
                        n.settings.multi_selection
                    );
                } catch (q) {
                    p({ success: false });
                    return;
                }
                if (g[n.id]) {
                    return;
                }
                g[n.id] = true;
                n.bind("UploadFile", function (t, v) {
                    var w = t.settings,
                        u = n.settings.resize || {};
                    o().uploadFile(s[v.id], w.url, {
                        name: v.target_name || v.name,
                        mime:
                            d.mimeTypes[
                                v.name
                                    .replace(/^.+\.([^.]+)/, "$1")
                                    .toLowerCase()
                            ] || "application/octet-stream",
                        chunk_size: w.chunk_size,
                        width: u.width,
                        height: u.height,
                        quality: u.quality,
                        multipart: w.multipart,
                        multipart_params: w.multipart_params || {},
                        file_data_name: w.file_data_name,
                        format: /\.(jpg|jpeg)$/i.test(v.name) ? "jpg" : "png",
                        headers: w.headers,
                        urlstream_upload: w.urlstream_upload,
                    });
                });
                n.bind("CancelUpload", function () {
                    o().cancelUpload();
                });
                n.bind("Flash:UploadProcess", function (u, t) {
                    var v = u.getFile(s[t.id]);
                    if (v.status != d.FAILED) {
                        v.loaded = t.loaded;
                        v.size = t.size;
                        u.trigger("UploadProgress", v);
                    }
                });
                n.bind("Flash:UploadChunkComplete", function (t, v) {
                    var w,
                        u = t.getFile(s[v.id]);
                    w = { chunk: v.chunk, chunks: v.chunks, response: v.text };
                    t.trigger("ChunkUploaded", u, w);
                    if (u.status !== d.FAILED && t.state !== d.STOPPED) {
                        o().uploadNextChunk();
                    }
                    if (v.chunk == v.chunks - 1) {
                        u.status = d.DONE;
                        t.trigger("FileUploaded", u, { response: v.text });
                    }
                });
                n.bind("Flash:SelectFiles", function (t, w) {
                    var v,
                        u,
                        x = [],
                        y;
                    for (u = 0; u < w.length; u++) {
                        v = w[u];
                        y = d.guid();
                        s[y] = v.id;
                        s[v.id] = y;
                        x.push(new d.File(y, v.name, v.size));
                    }
                    if (x.length) {
                        n.trigger("FilesAdded", x);
                    }
                });
                n.bind("Flash:SecurityError", function (t, u) {
                    n.trigger("Error", {
                        code: d.SECURITY_ERROR,
                        message: d.translate("Security error."),
                        details: u.message,
                        file: n.getFile(s[u.id]),
                    });
                });
                n.bind("Flash:GenericError", function (t, u) {
                    n.trigger("Error", {
                        code: d.GENERIC_ERROR,
                        message: d.translate("Generic error."),
                        details: u.message,
                        file: n.getFile(s[u.id]),
                    });
                });
                n.bind("Flash:IOError", function (t, u) {
                    n.trigger("Error", {
                        code: d.IO_ERROR,
                        message: d.translate("IO error."),
                        details: u.message,
                        file: n.getFile(s[u.id]),
                    });
                });
                n.bind("Flash:ImageError", function (t, u) {
                    n.trigger("Error", {
                        code: parseInt(u.code, 10),
                        message: d.translate("Image error."),
                        file: n.getFile(s[u.id]),
                    });
                });
                n.bind("Flash:StageEvent:rollOver", function (t) {
                    var u, v;
                    u = b.getElementById(n.settings.browse_button);
                    v = t.settings.browse_button_hover;
                    if (u && v) {
                        d.addClass(u, v);
                    }
                });
                n.bind("Flash:StageEvent:rollOut", function (t) {
                    var u, v;
                    u = b.getElementById(n.settings.browse_button);
                    v = t.settings.browse_button_hover;
                    if (u && v) {
                        d.removeClass(u, v);
                    }
                });
                n.bind("Flash:StageEvent:mouseDown", function (t) {
                    var u, v;
                    u = b.getElementById(n.settings.browse_button);
                    v = t.settings.browse_button_active;
                    if (u && v) {
                        d.addClass(u, v);
                        d.addEvent(
                            b.body,
                            "mouseup",
                            function () {
                                d.removeClass(u, v);
                            },
                            t.id
                        );
                    }
                });
                n.bind("Flash:StageEvent:mouseUp", function (t) {
                    var u, v;
                    u = b.getElementById(n.settings.browse_button);
                    v = t.settings.browse_button_active;
                    if (u && v) {
                        d.removeClass(u, v);
                    }
                });
                n.bind("Flash:ExifData", function (t, u) {
                    n.trigger("ExifData", n.getFile(s[u.id]), u.data);
                });
                n.bind("Flash:GpsData", function (t, u) {
                    n.trigger("GpsData", n.getFile(s[u.id]), u.data);
                });
                n.bind("QueueChanged", function (t) {
                    n.refresh();
                });
                n.bind("FilesRemoved", function (t, v) {
                    var u;
                    for (u = 0; u < v.length; u++) {
                        o().removeFile(s[v[u].id]);
                    }
                });
                n.bind("StateChanged", function (t) {
                    n.refresh();
                });
                n.bind("Refresh", function (t) {
                    var u, v, w;
                    o().setFileFilters(
                        n.settings.filters,
                        n.settings.multi_selection
                    );
                    u = b.getElementById(t.settings.browse_button);
                    if (u) {
                        v = d.getPos(u, b.getElementById(t.settings.container));
                        w = d.getSize(u);
                        d.extend(
                            b.getElementById(t.id + "_flash_container").style,
                            {
                                top: v.y + "px",
                                left: v.x + "px",
                                width: w.w + "px",
                                height: w.h + "px",
                            }
                        );
                    }
                });
                n.bind("DisableBrowse", function (t, u) {
                    o().disableBrowse(u);
                });
                p({ success: true });
            });
        },
    });
})(window, document, plupload);
(function (a) {
    a.runtimes.BrowserPlus = a.addRuntime("browserplus", {
        getFeatures: function () {
            return {
                dragdrop: true,
                jpgresize: true,
                pngresize: true,
                chunks: true,
                progress: true,
                multipart: true,
                multi_selection: true,
            };
        },
        init: function (g, j) {
            var e = window.BrowserPlus,
                h = {},
                d = g.settings,
                c = d.resize;
            function f(o) {
                var n,
                    m,
                    k = [],
                    l,
                    p;
                for (m = 0; m < o.length; m++) {
                    l = o[m];
                    p = a.guid();
                    h[p] = l;
                    k.push(new a.File(p, l.name, l.size));
                }
                if (m) {
                    g.trigger("FilesAdded", k);
                }
            }
            function b() {
                var k = false;
                g.bind("PostInit", function () {
                    var o,
                        m = d.drop_element,
                        q = g.id + "_droptarget",
                        l = document.getElementById(m),
                        n;
                    function r(t, s) {
                        e.DragAndDrop.AddDropTarget({ id: t }, function (u) {
                            e.DragAndDrop.AttachCallbacks(
                                {
                                    id: t,
                                    hover: function (v) {
                                        if (!v && s) {
                                            s();
                                        }
                                    },
                                    drop: function (v) {
                                        if (s) {
                                            s();
                                        }
                                        f(v);
                                    },
                                },
                                function () {}
                            );
                        });
                    }
                    function p() {
                        document.getElementById(q).style.top = "-1000px";
                    }
                    if (l) {
                        if (
                            document.attachEvent &&
                            /MSIE/gi.test(navigator.userAgent)
                        ) {
                            o = document.createElement("div");
                            o.setAttribute("id", q);
                            a.extend(o.style, {
                                position: "absolute",
                                top: "-1000px",
                                background: "red",
                                filter: "alpha(opacity=0)",
                                opacity: 0,
                            });
                            document.body.appendChild(o);
                            a.addEvent(l, "dragenter", function (t) {
                                var s, u;
                                s = document.getElementById(m);
                                u = a.getPos(s);
                                a.extend(document.getElementById(q).style, {
                                    top: u.y + "px",
                                    left: u.x + "px",
                                    width: s.offsetWidth + "px",
                                    height: s.offsetHeight + "px",
                                });
                            });
                            r(q, p);
                        } else {
                            r(m);
                        }
                    }
                    a.addEvent(
                        document.getElementById(d.browse_button),
                        "click",
                        function (y) {
                            var s = [],
                                u,
                                t,
                                x = d.filters,
                                w,
                                v;
                            y.preventDefault();
                            if (k) {
                                return;
                            }
                            no_type_restriction: for (
                                u = 0;
                                u < x.length;
                                u++
                            ) {
                                w = x[u].extensions.split(",");
                                for (t = 0; t < w.length; t++) {
                                    if (w[t] === "*") {
                                        s = [];
                                        break no_type_restriction;
                                    }
                                    v = a.mimeTypes[w[t]];
                                    if (v && a.inArray(v, s) === -1) {
                                        s.push(a.mimeTypes[w[t]]);
                                    }
                                }
                            }
                            e.FileBrowse.OpenBrowseDialog(
                                { mimeTypes: s },
                                function (z) {
                                    if (z.success) {
                                        f(z.value);
                                    }
                                }
                            );
                        }
                    );
                    l = o = null;
                });
                g.bind("CancelUpload", function () {
                    e.Uploader.cancel({}, function () {});
                });
                g.bind("DisableBrowse", function (l, m) {
                    k = m;
                });
                g.bind("UploadFile", function (o, l) {
                    var n = h[l.id],
                        t = {},
                        m = o.settings.chunk_size,
                        p,
                        q = [];
                    function s(u, w) {
                        var v;
                        if (l.status == a.FAILED) {
                            return;
                        }
                        t.name = l.target_name || l.name;
                        if (m) {
                            t.chunk = "" + u;
                            t.chunks = "" + w;
                        }
                        v = q.shift();
                        e.Uploader.upload(
                            {
                                url: o.settings.url,
                                files: { file: v },
                                cookies: document.cookies,
                                postvars: a.extend(
                                    t,
                                    o.settings.multipart_params
                                ),
                                progressCallback: function (z) {
                                    var y,
                                        x = 0;
                                    p[u] = parseInt(
                                        (z.filePercent * v.size) / 100,
                                        10
                                    );
                                    for (y = 0; y < p.length; y++) {
                                        x += p[y];
                                    }
                                    l.loaded = x;
                                    o.trigger("UploadProgress", l);
                                },
                            },
                            function (y) {
                                var x, z;
                                if (y.success) {
                                    x = y.value.statusCode;
                                    if (m) {
                                        o.trigger("ChunkUploaded", l, {
                                            chunk: u,
                                            chunks: w,
                                            response: y.value.body,
                                            status: x,
                                        });
                                    }
                                    if (q.length > 0) {
                                        s(++u, w);
                                    } else {
                                        l.status = a.DONE;
                                        o.trigger("FileUploaded", l, {
                                            response: y.value.body,
                                            status: x,
                                        });
                                        if (x >= 400) {
                                            o.trigger("Error", {
                                                code: a.HTTP_ERROR,
                                                message:
                                                    a.translate("HTTP Error."),
                                                file: l,
                                                status: x,
                                            });
                                        }
                                    }
                                } else {
                                    o.trigger("Error", {
                                        code: a.GENERIC_ERROR,
                                        message: a.translate("Generic Error."),
                                        file: l,
                                        details: y.error,
                                    });
                                }
                            }
                        );
                    }
                    function r(u) {
                        l.size = u.size;
                        if (m) {
                            e.FileAccess.chunk(
                                { file: u, chunkSize: m },
                                function (x) {
                                    if (x.success) {
                                        var y = x.value,
                                            v = y.length;
                                        p = Array(v);
                                        for (var w = 0; w < v; w++) {
                                            p[w] = 0;
                                            q.push(y[w]);
                                        }
                                        s(0, v);
                                    }
                                }
                            );
                        } else {
                            p = Array(1);
                            q.push(u);
                            s(0, 1);
                        }
                    }
                    if (c && /\.(png|jpg|jpeg)$/i.test(l.name)) {
                        BrowserPlus.ImageAlter.transform(
                            {
                                file: n,
                                quality: c.quality || 90,
                                actions: [
                                    {
                                        scale: {
                                            maxwidth: c.width,
                                            maxheight: c.height,
                                        },
                                    },
                                ],
                            },
                            function (u) {
                                if (u.success) {
                                    r(u.value.file);
                                }
                            }
                        );
                    } else {
                        r(n);
                    }
                });
                j({ success: true });
            }
            if (e) {
                e.init(function (l) {
                    var k = [
                        { service: "Uploader", version: "3" },
                        { service: "DragAndDrop", version: "1" },
                        { service: "FileBrowse", version: "1" },
                        { service: "FileAccess", version: "2" },
                    ];
                    if (c) {
                        k.push({ service: "ImageAlter", version: "4" });
                    }
                    if (l.success) {
                        e.require({ services: k }, function (m) {
                            if (m.success) {
                                b();
                            } else {
                                j();
                            }
                        });
                    } else {
                        j();
                    }
                });
            } else {
                j();
            }
        },
    });
})(plupload);
(function (k, m, l, g) {
    var d = {},
        j;
    function c(s) {
        var r = s.naturalWidth,
            u = s.naturalHeight;
        if (r * u > 1024 * 1024) {
            var t = m.createElement("canvas");
            t.width = t.height = 1;
            var q = t.getContext("2d");
            q.drawImage(s, -r + 1, 0);
            return q.getImageData(0, 0, 1, 1).data[3] === 0;
        } else {
            return false;
        }
    }
    function f(u, r, z) {
        var q = m.createElement("canvas");
        q.width = 1;
        q.height = z;
        var A = q.getContext("2d");
        A.drawImage(u, 0, 0);
        var t = A.getImageData(0, 0, 1, z).data;
        var x = 0;
        var v = z;
        var y = z;
        while (y > x) {
            var s = t[(y - 1) * 4 + 3];
            if (s === 0) {
                v = y;
            } else {
                x = y;
            }
            y = (v + x) >> 1;
        }
        var w = y / z;
        return w === 0 ? 1 : w;
    }
    function o(K, s, t) {
        var v = K.naturalWidth,
            z = K.naturalHeight;
        var E = t.width,
            B = t.height;
        var F = s.getContext("2d");
        F.save();
        var r = c(K);
        if (r) {
            v /= 2;
            z /= 2;
        }
        var I = 1024;
        var q = m.createElement("canvas");
        q.width = q.height = I;
        var u = q.getContext("2d");
        var G = f(K, v, z);
        var A = 0;
        while (A < z) {
            var J = A + I > z ? z - A : I;
            var C = 0;
            while (C < v) {
                var D = C + I > v ? v - C : I;
                u.clearRect(0, 0, I, I);
                u.drawImage(K, -C, -A);
                var x = ((C * E) / v) << 0;
                var y = Math.ceil((D * E) / v);
                var w = ((A * B) / z / G) << 0;
                var H = Math.ceil((J * B) / z / G);
                F.drawImage(q, 0, 0, D, J, x, w, y, H);
                C += I;
            }
            A += I;
        }
        F.restore();
        q = u = null;
    }
    function p(r, s) {
        var q;
        if ("FileReader" in k) {
            q = new FileReader();
            q.readAsDataURL(r);
            q.onload = function () {
                s(q.result);
            };
        } else {
            return s(r.getAsDataURL());
        }
    }
    function n(r, s) {
        var q;
        if ("FileReader" in k) {
            q = new FileReader();
            q.readAsBinaryString(r);
            q.onload = function () {
                s(q.result);
            };
        } else {
            return s(r.getAsBinary());
        }
    }
    function e(u, s, q, y) {
        var t,
            r,
            x,
            v,
            w = this;
        p(d[u.id], function (z) {
            t = m.createElement("canvas");
            t.style.display = "none";
            m.body.appendChild(t);
            x = new Image();
            x.onerror = x.onabort = function () {
                y({ success: false });
            };
            x.onload = function () {
                var F, A, C, B, E;
                if (!s.width) {
                    s.width = x.width;
                }
                if (!s.height) {
                    s.height = x.height;
                }
                v = Math.min(s.width / x.width, s.height / x.height);
                if (v < 1) {
                    F = Math.round(x.width * v);
                    A = Math.round(x.height * v);
                } else {
                    if (s.quality && q === "image/jpeg") {
                        F = x.width;
                        A = x.height;
                    } else {
                        y({ success: false });
                        return;
                    }
                }
                t.width = F;
                t.height = A;
                o(x, t, { width: F, height: A });
                if (q === "image/jpeg") {
                    B = new h(atob(z.substring(z.indexOf("base64,") + 7)));
                    if (B.headers && B.headers.length) {
                        E = new a();
                        if (E.init(B.get("exif")[0])) {
                            E.setExif("PixelXDimension", F);
                            E.setExif("PixelYDimension", A);
                            B.set("exif", E.getBinary());
                            if (w.hasEventListener("ExifData")) {
                                w.trigger("ExifData", u, E.EXIF());
                            }
                            if (w.hasEventListener("GpsData")) {
                                w.trigger("GpsData", u, E.GPS());
                            }
                        }
                    }
                }
                if (s.quality && q === "image/jpeg") {
                    try {
                        z = t.toDataURL(q, s.quality / 100);
                    } catch (D) {
                        z = t.toDataURL(q);
                    }
                } else {
                    z = t.toDataURL(q);
                }
                z = z.substring(z.indexOf("base64,") + 7);
                z = atob(z);
                if (B && B.headers && B.headers.length) {
                    z = B.restore(z);
                    B.purge();
                }
                t.parentNode.removeChild(t);
                y({ success: true, data: z });
            };
            x.src = z;
        });
    }
    l.runtimes.Html5 = l.addRuntime("html5", {
        getFeatures: function () {
            var v, r, u, t, s, q;
            r = u = s = q = false;
            if (k.XMLHttpRequest) {
                v = new XMLHttpRequest();
                u = !!v.upload;
                r = !!(v.sendAsBinary || v.upload);
            }
            if (r) {
                t = !!(v.sendAsBinary || (k.Uint8Array && k.ArrayBuffer));
                s = !!(
                    File &&
                    (File.prototype.getAsDataURL || k.FileReader) &&
                    t
                );
                q = !!(
                    File &&
                    (File.prototype.mozSlice ||
                        File.prototype.webkitSlice ||
                        File.prototype.slice)
                );
            }
            j = l.ua.safari && l.ua.windows;
            return {
                html5: r,
                dragdrop: (function () {
                    var w = m.createElement("div");
                    return (
                        "draggable" in w ||
                        ("ondragstart" in w && "ondrop" in w)
                    );
                })(),
                jpgresize: s,
                pngresize: s,
                multipart: s || !!k.FileReader || !!k.FormData,
                canSendBinary: t,
                cantSendBlobInFormData:
                    !!(
                        l.ua.gecko &&
                        k.FormData &&
                        k.FileReader &&
                        !FileReader.prototype.readAsArrayBuffer
                    ) || l.ua.android,
                progress: u,
                chunks: q,
                multi_selection: !(l.ua.safari && l.ua.windows),
                triggerDialog: (l.ua.gecko && k.FormData) || l.ua.webkit,
            };
        },
        init: function (s, u) {
            var q, t;
            function r(z) {
                var x,
                    w,
                    y = [],
                    A,
                    v = {};
                for (w = 0; w < z.length; w++) {
                    x = z[w];
                    if (v[x.name] && l.ua.safari && l.ua.windows) {
                        continue;
                    }
                    v[x.name] = true;
                    A = l.guid();
                    d[A] = x;
                    y.push(
                        new l.File(
                            A,
                            x.fileName || x.name,
                            x.fileSize || x.size
                        )
                    );
                }
                if (y.length) {
                    s.trigger("FilesAdded", y);
                }
            }
            q = this.getFeatures();
            if (!q.html5) {
                u({ success: false });
                return;
            }
            s.bind("Init", function (A) {
                var J,
                    I,
                    F = [],
                    z,
                    G,
                    w = A.settings.filters,
                    x,
                    E,
                    v = m.body,
                    H;
                J = m.createElement("div");
                J.id = A.id + "_html5_container";
                l.extend(J.style, {
                    position: "absolute",
                    background: s.settings.shim_bgcolor || "transparent",
                    width: "100px",
                    height: "100px",
                    overflow: "hidden",
                    zIndex: 99999,
                    opacity: s.settings.shim_bgcolor ? "" : 0,
                });
                J.className = "plupload html5";
                if (s.settings.container) {
                    v = m.getElementById(s.settings.container);
                    if (l.getStyle(v, "position") === "static") {
                        v.style.position = "relative";
                    }
                }
                v.appendChild(J);
                no_type_restriction: for (z = 0; z < w.length; z++) {
                    x = w[z].extensions.split(/,/);
                    for (G = 0; G < x.length; G++) {
                        if (x[G] === "*") {
                            F = [];
                            break no_type_restriction;
                        }
                        E = l.mimeTypes[x[G]];
                        if (E && l.inArray(E, F) === -1) {
                            F.push(E);
                        }
                    }
                }
                J.innerHTML =
                    '<input id="' +
                    s.id +
                    '_html5"  style="font-size:999px" type="file" accept="' +
                    F.join(",") +
                    '" ' +
                    (s.settings.multi_selection && s.features.multi_selection
                        ? 'multiple="multiple"'
                        : "") +
                    " />";
                J.scrollTop = 100;
                H = m.getElementById(s.id + "_html5");
                if (A.features.triggerDialog) {
                    l.extend(H.style, {
                        position: "absolute",
                        width: "100%",
                        height: "100%",
                    });
                } else {
                    l.extend(H.style, {
                        cssFloat: "right",
                        styleFloat: "right",
                    });
                }
                H.onchange = function () {
                    r(this.files);
                    this.value = "";
                };
                I = m.getElementById(A.settings.browse_button);
                if (I) {
                    var C = A.settings.browse_button_hover,
                        D = A.settings.browse_button_active,
                        B = A.features.triggerDialog ? I : J;
                    if (C) {
                        l.addEvent(
                            B,
                            "mouseover",
                            function () {
                                l.addClass(I, C);
                            },
                            A.id
                        );
                        l.addEvent(
                            B,
                            "mouseout",
                            function () {
                                l.removeClass(I, C);
                            },
                            A.id
                        );
                    }
                    if (D) {
                        l.addEvent(
                            B,
                            "mousedown",
                            function () {
                                l.addClass(I, D);
                            },
                            A.id
                        );
                        l.addEvent(
                            m.body,
                            "mouseup",
                            function () {
                                l.removeClass(I, D);
                            },
                            A.id
                        );
                    }
                    if (A.features.triggerDialog) {
                        l.addEvent(
                            I,
                            "click",
                            function (K) {
                                var y = m.getElementById(A.id + "_html5");
                                if (y && !y.disabled) {
                                    y.click();
                                }
                                K.preventDefault();
                            },
                            A.id
                        );
                    }
                }
            });
            s.bind("PostInit", function () {
                var v = m.getElementById(s.settings.drop_element);
                if (v) {
                    if (j) {
                        l.addEvent(
                            v,
                            "dragenter",
                            function (z) {
                                var y, w, x;
                                y = m.getElementById(s.id + "_drop");
                                if (!y) {
                                    y = m.createElement("input");
                                    y.setAttribute("type", "file");
                                    y.setAttribute("id", s.id + "_drop");
                                    y.setAttribute("multiple", "multiple");
                                    l.addEvent(
                                        y,
                                        "change",
                                        function () {
                                            r(this.files);
                                            l.removeEvent(y, "change", s.id);
                                            y.parentNode.removeChild(y);
                                        },
                                        s.id
                                    );
                                    l.addEvent(
                                        y,
                                        "dragover",
                                        function (A) {
                                            A.stopPropagation();
                                        },
                                        s.id
                                    );
                                    v.appendChild(y);
                                }
                                w = l.getPos(
                                    v,
                                    m.getElementById(s.settings.container)
                                );
                                x = l.getSize(v);
                                if (l.getStyle(v, "position") === "static") {
                                    l.extend(v.style, { position: "relative" });
                                }
                                l.extend(y.style, {
                                    position: "absolute",
                                    display: "block",
                                    top: 0,
                                    left: 0,
                                    width: x.w + "px",
                                    height: x.h + "px",
                                    opacity: 0,
                                });
                            },
                            s.id
                        );
                        return;
                    }
                    l.addEvent(
                        v,
                        "dragover",
                        function (w) {
                            w.preventDefault();
                        },
                        s.id
                    );
                    l.addEvent(
                        v,
                        "drop",
                        function (x) {
                            var w = x.dataTransfer;
                            if (w && w.files) {
                                r(w.files);
                            }
                            x.preventDefault();
                        },
                        s.id
                    );
                }
            });
            s.bind("Refresh", function (v) {
                var w, x, y, A, z;
                w = m.getElementById(s.settings.browse_button);
                if (w) {
                    x = l.getPos(w, m.getElementById(v.settings.container));
                    y = l.getSize(w);
                    A = m.getElementById(s.id + "_html5_container");
                    l.extend(A.style, {
                        top: x.y + "px",
                        left: x.x + "px",
                        width: y.w + "px",
                        height: y.h + "px",
                    });
                    if (s.features.triggerDialog) {
                        if (l.getStyle(w, "position") === "static") {
                            l.extend(w.style, { position: "relative" });
                        }
                        z = parseInt(l.getStyle(w, "zIndex"), 10);
                        if (isNaN(z)) {
                            z = 0;
                        }
                        l.extend(w.style, { zIndex: z });
                        l.extend(A.style, { zIndex: z - 1 });
                    }
                }
            });
            s.bind("DisableBrowse", function (v, x) {
                var w = m.getElementById(v.id + "_html5");
                if (w) {
                    w.disabled = x;
                }
            });
            s.bind("CancelUpload", function () {
                if (t && t.abort) {
                    t.abort();
                }
            });
            s.bind("UploadFile", function (v, x) {
                var y = v.settings,
                    B,
                    w;
                function A(D, G, C) {
                    var E;
                    if (File.prototype.slice) {
                        try {
                            D.slice();
                            return D.slice(G, C);
                        } catch (F) {
                            return D.slice(G, C - G);
                        }
                    } else {
                        if (
                            (E =
                                File.prototype.webkitSlice ||
                                File.prototype.mozSlice)
                        ) {
                            return E.call(D, G, C);
                        } else {
                            return null;
                        }
                    }
                }
                function z(C) {
                    var F = 0,
                        E = 0;
                    function D() {
                        var L,
                            P,
                            N,
                            O,
                            K,
                            M,
                            H,
                            G = v.settings.url;
                        function J(S) {
                            if (t.sendAsBinary) {
                                t.sendAsBinary(S);
                            } else {
                                if (v.features.canSendBinary) {
                                    var Q = new Uint8Array(S.length);
                                    for (var R = 0; R < S.length; R++) {
                                        Q[R] = S.charCodeAt(R) & 255;
                                    }
                                    t.send(Q.buffer);
                                }
                            }
                        }
                        function I(R) {
                            var V = 0,
                                W = "----pluploadboundary" + l.guid(),
                                T,
                                S = "--",
                                U = "\r\n",
                                Q = "";
                            t = new XMLHttpRequest();
                            if (t.upload) {
                                t.upload.onprogress = function (X) {
                                    x.loaded = Math.min(
                                        x.size,
                                        E + X.loaded - V
                                    );
                                    v.trigger("UploadProgress", x);
                                };
                            }
                            t.onreadystatechange = function () {
                                var X, Z;
                                if (
                                    t.readyState == 4 &&
                                    v.state !== l.STOPPED
                                ) {
                                    try {
                                        X = t.status;
                                    } catch (Y) {
                                        X = 0;
                                    }
                                    if (X >= 400) {
                                        v.trigger("Error", {
                                            code: l.HTTP_ERROR,
                                            message: l.translate("HTTP Error."),
                                            file: x,
                                            status: X,
                                        });
                                    } else {
                                        if (N) {
                                            Z = {
                                                chunk: F,
                                                chunks: N,
                                                response: t.responseText,
                                                status: X,
                                            };
                                            v.trigger("ChunkUploaded", x, Z);
                                            E += M;
                                            if (Z.cancelled) {
                                                x.status = l.FAILED;
                                                return;
                                            }
                                            x.loaded = Math.min(
                                                x.size,
                                                (F + 1) * K
                                            );
                                        } else {
                                            x.loaded = x.size;
                                        }
                                        v.trigger("UploadProgress", x);
                                        R = L = T = Q = null;
                                        if (!N || ++F >= N) {
                                            x.status = l.DONE;
                                            v.trigger("FileUploaded", x, {
                                                response: t.responseText,
                                                status: X,
                                            });
                                        } else {
                                            D();
                                        }
                                    }
                                }
                            };
                            if (v.settings.multipart && q.multipart) {
                                O.name = x.target_name || x.name;
                                t.open("post", G, true);
                                l.each(v.settings.headers, function (Y, X) {
                                    t.setRequestHeader(X, Y);
                                });
                                if (typeof R !== "string" && !!k.FormData) {
                                    T = new FormData();
                                    l.each(
                                        l.extend(
                                            O,
                                            v.settings.multipart_params
                                        ),
                                        function (Y, X) {
                                            T.append(X, Y);
                                        }
                                    );
                                    T.append(v.settings.file_data_name, R);
                                    t.send(T);
                                    return;
                                }
                                if (typeof R === "string") {
                                    t.setRequestHeader(
                                        "Content-Type",
                                        "multipart/form-data; boundary=" + W
                                    );
                                    l.each(
                                        l.extend(
                                            O,
                                            v.settings.multipart_params
                                        ),
                                        function (Y, X) {
                                            Q +=
                                                S +
                                                W +
                                                U +
                                                'Content-Disposition: form-data; name="' +
                                                X +
                                                '"' +
                                                U +
                                                U;
                                            Q +=
                                                unescape(
                                                    encodeURIComponent(Y)
                                                ) + U;
                                        }
                                    );
                                    H =
                                        l.mimeTypes[
                                            x.name
                                                .replace(/^.+\.([^.]+)/, "$1")
                                                .toLowerCase()
                                        ] || "application/octet-stream";
                                    Q +=
                                        S +
                                        W +
                                        U +
                                        'Content-Disposition: form-data; name="' +
                                        v.settings.file_data_name +
                                        '"; filename="' +
                                        unescape(encodeURIComponent(x.name)) +
                                        '"' +
                                        U +
                                        "Content-Type: " +
                                        H +
                                        U +
                                        U +
                                        R +
                                        U +
                                        S +
                                        W +
                                        S +
                                        U;
                                    V = Q.length - R.length;
                                    R = Q;
                                    J(R);
                                    return;
                                }
                            }
                            G = l.buildUrl(
                                v.settings.url,
                                l.extend(O, v.settings.multipart_params)
                            );
                            t.open("post", G, true);
                            t.setRequestHeader(
                                "Content-Type",
                                "application/octet-stream"
                            );
                            l.each(v.settings.headers, function (Y, X) {
                                t.setRequestHeader(X, Y);
                            });
                            if (typeof R === "string") {
                                J(R);
                            } else {
                                t.send(R);
                            }
                        }
                        if (
                            x.status == l.DONE ||
                            x.status == l.FAILED ||
                            v.state == l.STOPPED
                        ) {
                            return;
                        }
                        O = { name: x.target_name || x.name };
                        if (
                            y.chunk_size &&
                            x.size > y.chunk_size &&
                            (q.chunks || typeof C == "string")
                        ) {
                            K = y.chunk_size;
                            N = Math.ceil(x.size / K);
                            M = Math.min(K, x.size - F * K);
                            if (typeof C == "string") {
                                L = C.substring(F * K, F * K + M);
                            } else {
                                L = A(C, F * K, F * K + M);
                            }
                            O.chunk = F;
                            O.chunks = N;
                        } else {
                            M = x.size;
                            L = C;
                        }
                        if (
                            v.settings.multipart &&
                            q.multipart &&
                            typeof L !== "string" &&
                            k.FileReader &&
                            q.cantSendBlobInFormData &&
                            q.chunks &&
                            v.settings.chunk_size
                        ) {
                            (function () {
                                var Q = new FileReader();
                                Q.onload = function () {
                                    I(Q.result);
                                    Q = null;
                                };
                                Q.readAsBinaryString(L);
                            })();
                        } else {
                            I(L);
                        }
                    }
                    D();
                }
                B = d[x.id];
                if (
                    q.jpgresize &&
                    v.settings.resize &&
                    /\.(png|jpg|jpeg)$/i.test(x.name)
                ) {
                    e.call(
                        v,
                        x,
                        v.settings.resize,
                        /\.png$/i.test(x.name) ? "image/png" : "image/jpeg",
                        function (C) {
                            if (C.success) {
                                x.size = C.data.length;
                                z(C.data);
                            } else {
                                if (q.chunks) {
                                    z(B);
                                } else {
                                    n(B, z);
                                }
                            }
                        }
                    );
                } else {
                    if (!q.chunks && q.jpgresize) {
                        n(B, z);
                    } else {
                        z(B);
                    }
                }
            });
            s.bind("Destroy", function (v) {
                var x,
                    y,
                    w = m.body,
                    z = {
                        inputContainer: v.id + "_html5_container",
                        inputFile: v.id + "_html5",
                        browseButton: v.settings.browse_button,
                        dropElm: v.settings.drop_element,
                    };
                for (x in z) {
                    y = m.getElementById(z[x]);
                    if (y) {
                        l.removeAllEvents(y, v.id);
                    }
                }
                l.removeAllEvents(m.body, v.id);
                if (v.settings.container) {
                    w = m.getElementById(v.settings.container);
                }
                w.removeChild(m.getElementById(z.inputContainer));
            });
            u({ success: true });
        },
    });
    function b() {
        var t = false,
            r;
        function u(w, y) {
            var v = t ? 0 : -8 * (y - 1),
                z = 0,
                x;
            for (x = 0; x < y; x++) {
                z |= r.charCodeAt(w + x) << Math.abs(v + x * 8);
            }
            return z;
        }
        function q(x, v, w) {
            var w = arguments.length === 3 ? w : r.length - v - 1;
            r = r.substr(0, v) + x + r.substr(w + v);
        }
        function s(w, x, z) {
            var A = "",
                v = t ? 0 : -8 * (z - 1),
                y;
            for (y = 0; y < z; y++) {
                A += String.fromCharCode((x >> Math.abs(v + y * 8)) & 255);
            }
            q(A, w, z);
        }
        return {
            II: function (v) {
                if (v === g) {
                    return t;
                } else {
                    t = v;
                }
            },
            init: function (v) {
                t = false;
                r = v;
            },
            SEGMENT: function (v, x, w) {
                switch (arguments.length) {
                    case 1:
                        return r.substr(v, r.length - v - 1);
                    case 2:
                        return r.substr(v, x);
                    case 3:
                        q(w, v, x);
                        break;
                    default:
                        return r;
                }
            },
            BYTE: function (v) {
                return u(v, 1);
            },
            SHORT: function (v) {
                return u(v, 2);
            },
            LONG: function (v, w) {
                if (w === g) {
                    return u(v, 4);
                } else {
                    s(v, w, 4);
                }
            },
            SLONG: function (v) {
                var w = u(v, 4);
                return w > 2147483647 ? w - 4294967296 : w;
            },
            STRING: function (v, w) {
                var x = "";
                for (w += v; v < w; v++) {
                    x += String.fromCharCode(u(v, 1));
                }
                return x;
            },
        };
    }
    function h(v) {
        var x = {
                65505: { app: "EXIF", name: "APP1", signature: "Exif\0" },
                65506: { app: "ICC", name: "APP2", signature: "ICC_PROFILE\0" },
                65517: {
                    app: "IPTC",
                    name: "APP13",
                    signature: "Photoshop 3.0\0",
                },
            },
            w = [],
            u,
            q,
            s = g,
            t = 0,
            r;
        u = new b();
        u.init(v);
        if (u.SHORT(0) !== 65496) {
            return;
        }
        q = 2;
        r = Math.min(1048576, v.length);
        while (q <= r) {
            s = u.SHORT(q);
            if (s >= 65488 && s <= 65495) {
                q += 2;
                continue;
            }
            if (s === 65498 || s === 65497) {
                break;
            }
            t = u.SHORT(q + 2) + 2;
            if (
                x[s] &&
                u.STRING(q + 4, x[s].signature.length) === x[s].signature
            ) {
                w.push({
                    hex: s,
                    app: x[s].app.toUpperCase(),
                    name: x[s].name.toUpperCase(),
                    start: q,
                    length: t,
                    segment: u.SEGMENT(q, t),
                });
            }
            q += t;
        }
        u.init(null);
        return {
            headers: w,
            restore: function (B) {
                u.init(B);
                var z = new h(B);
                if (!z.headers) {
                    return false;
                }
                for (var A = z.headers.length; A > 0; A--) {
                    var C = z.headers[A - 1];
                    u.SEGMENT(C.start, C.length, "");
                }
                z.purge();
                q = u.SHORT(2) == 65504 ? 4 + u.SHORT(4) : 2;
                for (var A = 0, y = w.length; A < y; A++) {
                    u.SEGMENT(q, 0, w[A].segment);
                    q += w[A].length;
                }
                return u.SEGMENT();
            },
            get: function (A) {
                var B = [];
                for (var z = 0, y = w.length; z < y; z++) {
                    if (w[z].app === A.toUpperCase()) {
                        B.push(w[z].segment);
                    }
                }
                return B;
            },
            set: function (B, A) {
                var C = [];
                if (typeof A === "string") {
                    C.push(A);
                } else {
                    C = A;
                }
                for (var z = (ii = 0), y = w.length; z < y; z++) {
                    if (w[z].app === B.toUpperCase()) {
                        w[z].segment = C[ii];
                        w[z].length = C[ii].length;
                        ii++;
                    }
                    if (ii >= C.length) {
                        break;
                    }
                }
            },
            purge: function () {
                w = [];
                u.init(null);
            },
        };
    }
    function a() {
        var t,
            q,
            r = {},
            w;
        t = new b();
        q = {
            tiff: {
                274: "Orientation",
                34665: "ExifIFDPointer",
                34853: "GPSInfoIFDPointer",
            },
            exif: {
                36864: "ExifVersion",
                40961: "ColorSpace",
                40962: "PixelXDimension",
                40963: "PixelYDimension",
                36867: "DateTimeOriginal",
                33434: "ExposureTime",
                33437: "FNumber",
                34855: "ISOSpeedRatings",
                37377: "ShutterSpeedValue",
                37378: "ApertureValue",
                37383: "MeteringMode",
                37384: "LightSource",
                37385: "Flash",
                41986: "ExposureMode",
                41987: "WhiteBalance",
                41990: "SceneCaptureType",
                41988: "DigitalZoomRatio",
                41992: "Contrast",
                41993: "Saturation",
                41994: "Sharpness",
            },
            gps: {
                0: "GPSVersionID",
                1: "GPSLatitudeRef",
                2: "GPSLatitude",
                3: "GPSLongitudeRef",
                4: "GPSLongitude",
            },
        };
        w = {
            ColorSpace: { 1: "sRGB", 0: "Uncalibrated" },
            MeteringMode: {
                0: "Unknown",
                1: "Average",
                2: "CenterWeightedAverage",
                3: "Spot",
                4: "MultiSpot",
                5: "Pattern",
                6: "Partial",
                255: "Other",
            },
            LightSource: {
                1: "Daylight",
                2: "Fliorescent",
                3: "Tungsten",
                4: "Flash",
                9: "Fine weather",
                10: "Cloudy weather",
                11: "Shade",
                12: "Daylight fluorescent (D 5700 - 7100K)",
                13: "Day white fluorescent (N 4600 -5400K)",
                14: "Cool white fluorescent (W 3900 - 4500K)",
                15: "White fluorescent (WW 3200 - 3700K)",
                17: "Standard light A",
                18: "Standard light B",
                19: "Standard light C",
                20: "D55",
                21: "D65",
                22: "D75",
                23: "D50",
                24: "ISO studio tungsten",
                255: "Other",
            },
            Flash: {
                0: "Flash did not fire.",
                1: "Flash fired.",
                5: "Strobe return light not detected.",
                7: "Strobe return light detected.",
                9: "Flash fired, compulsory flash mode",
                13: "Flash fired, compulsory flash mode, return light not detected",
                15: "Flash fired, compulsory flash mode, return light detected",
                16: "Flash did not fire, compulsory flash mode",
                24: "Flash did not fire, auto mode",
                25: "Flash fired, auto mode",
                29: "Flash fired, auto mode, return light not detected",
                31: "Flash fired, auto mode, return light detected",
                32: "No flash function",
                65: "Flash fired, red-eye reduction mode",
                69: "Flash fired, red-eye reduction mode, return light not detected",
                71: "Flash fired, red-eye reduction mode, return light detected",
                73: "Flash fired, compulsory flash mode, red-eye reduction mode",
                77: "Flash fired, compulsory flash mode, red-eye reduction mode, return light not detected",
                79: "Flash fired, compulsory flash mode, red-eye reduction mode, return light detected",
                89: "Flash fired, auto mode, red-eye reduction mode",
                93: "Flash fired, auto mode, return light not detected, red-eye reduction mode",
                95: "Flash fired, auto mode, return light detected, red-eye reduction mode",
            },
            ExposureMode: {
                0: "Auto exposure",
                1: "Manual exposure",
                2: "Auto bracket",
            },
            WhiteBalance: {
                0: "Auto white balance",
                1: "Manual white balance",
            },
            SceneCaptureType: {
                0: "Standard",
                1: "Landscape",
                2: "Portrait",
                3: "Night scene",
            },
            Contrast: { 0: "Normal", 1: "Soft", 2: "Hard" },
            Saturation: {
                0: "Normal",
                1: "Low saturation",
                2: "High saturation",
            },
            Sharpness: { 0: "Normal", 1: "Soft", 2: "Hard" },
            GPSLatitudeRef: { N: "North latitude", S: "South latitude" },
            GPSLongitudeRef: { E: "East longitude", W: "West longitude" },
        };
        function s(x, F) {
            var z = t.SHORT(x),
                C,
                I,
                J,
                E,
                D,
                y,
                A,
                G,
                H = [],
                B = {};
            for (C = 0; C < z; C++) {
                A = y = x + 12 * C + 2;
                J = F[t.SHORT(A)];
                if (J === g) {
                    continue;
                }
                E = t.SHORT((A += 2));
                D = t.LONG((A += 2));
                A += 4;
                H = [];
                switch (E) {
                    case 1:
                    case 7:
                        if (D > 4) {
                            A = t.LONG(A) + r.tiffHeader;
                        }
                        for (I = 0; I < D; I++) {
                            H[I] = t.BYTE(A + I);
                        }
                        break;
                    case 2:
                        if (D > 4) {
                            A = t.LONG(A) + r.tiffHeader;
                        }
                        B[J] = t.STRING(A, D - 1);
                        continue;
                    case 3:
                        if (D > 2) {
                            A = t.LONG(A) + r.tiffHeader;
                        }
                        for (I = 0; I < D; I++) {
                            H[I] = t.SHORT(A + I * 2);
                        }
                        break;
                    case 4:
                        if (D > 1) {
                            A = t.LONG(A) + r.tiffHeader;
                        }
                        for (I = 0; I < D; I++) {
                            H[I] = t.LONG(A + I * 4);
                        }
                        break;
                    case 5:
                        A = t.LONG(A) + r.tiffHeader;
                        for (I = 0; I < D; I++) {
                            H[I] = t.LONG(A + I * 4) / t.LONG(A + I * 4 + 4);
                        }
                        break;
                    case 9:
                        A = t.LONG(A) + r.tiffHeader;
                        for (I = 0; I < D; I++) {
                            H[I] = t.SLONG(A + I * 4);
                        }
                        break;
                    case 10:
                        A = t.LONG(A) + r.tiffHeader;
                        for (I = 0; I < D; I++) {
                            H[I] = t.SLONG(A + I * 4) / t.SLONG(A + I * 4 + 4);
                        }
                        break;
                    default:
                        continue;
                }
                G = D == 1 ? H[0] : H;
                if (w.hasOwnProperty(J) && typeof G != "object") {
                    B[J] = w[J][G];
                } else {
                    B[J] = G;
                }
            }
            return B;
        }
        function v() {
            var y = g,
                x = r.tiffHeader;
            t.II(t.SHORT(x) == 18761);
            if (t.SHORT((x += 2)) !== 42) {
                return false;
            }
            r.IFD0 = r.tiffHeader + t.LONG((x += 2));
            y = s(r.IFD0, q.tiff);
            r.exifIFD =
                "ExifIFDPointer" in y ? r.tiffHeader + y.ExifIFDPointer : g;
            r.gpsIFD =
                "GPSInfoIFDPointer" in y
                    ? r.tiffHeader + y.GPSInfoIFDPointer
                    : g;
            return true;
        }
        function u(z, x, C) {
            var E,
                B,
                A,
                D = 0;
            if (typeof x === "string") {
                var y = q[z.toLowerCase()];
                for (hex in y) {
                    if (y[hex] === x) {
                        x = hex;
                        break;
                    }
                }
            }
            E = r[z.toLowerCase() + "IFD"];
            B = t.SHORT(E);
            for (i = 0; i < B; i++) {
                A = E + 12 * i + 2;
                if (t.SHORT(A) == x) {
                    D = A + 8;
                    break;
                }
            }
            if (!D) {
                return false;
            }
            t.LONG(D, C);
            return true;
        }
        return {
            init: function (x) {
                r = { tiffHeader: 10 };
                if (x === g || !x.length) {
                    return false;
                }
                t.init(x);
                if (
                    t.SHORT(0) === 65505 &&
                    t.STRING(4, 5).toUpperCase() === "EXIF\0"
                ) {
                    return v();
                }
                return false;
            },
            EXIF: function () {
                var y;
                y = s(r.exifIFD, q.exif);
                if (y.ExifVersion && l.typeOf(y.ExifVersion) === "array") {
                    for (var z = 0, x = ""; z < y.ExifVersion.length; z++) {
                        x += String.fromCharCode(y.ExifVersion[z]);
                    }
                    y.ExifVersion = x;
                }
                return y;
            },
            GPS: function () {
                var x;
                x = s(r.gpsIFD, q.gps);
                if (x.GPSVersionID) {
                    x.GPSVersionID = x.GPSVersionID.join(".");
                }
                return x;
            },
            setExif: function (x, y) {
                if (x !== "PixelXDimension" && x !== "PixelYDimension") {
                    return false;
                }
                return u("exif", x, y);
            },
            getBinary: function () {
                return t.SEGMENT();
            },
        };
    }
})(window, document, plupload);
(function (d, a, b, c) {
    function e(f) {
        return a.getElementById(f);
    }
    b.runtimes.Html4 = b.addRuntime("html4", {
        getFeatures: function () {
            return {
                multipart: true,
                triggerDialog: (b.ua.gecko && d.FormData) || b.ua.webkit,
            };
        },
        init: function (f, g) {
            f.bind("Init", function (p) {
                var j = a.body,
                    n,
                    h = "javascript",
                    k,
                    x,
                    q,
                    z = [],
                    r = /MSIE/.test(navigator.userAgent),
                    t = [],
                    m = p.settings.filters,
                    o,
                    l,
                    s,
                    w;
                no_type_restriction: for (o = 0; o < m.length; o++) {
                    l = m[o].extensions.split(/,/);
                    for (w = 0; w < l.length; w++) {
                        if (l[w] === "*") {
                            t = [];
                            break no_type_restriction;
                        }
                        s = b.mimeTypes[l[w]];
                        if (s && b.inArray(s, t) === -1) {
                            t.push(s);
                        }
                    }
                }
                t = t.join(",");
                function v() {
                    var C, A, y, B;
                    q = b.guid();
                    z.push(q);
                    C = a.createElement("form");
                    C.setAttribute("id", "form_" + q);
                    C.setAttribute("method", "post");
                    C.setAttribute("enctype", "multipart/form-data");
                    C.setAttribute("encoding", "multipart/form-data");
                    C.setAttribute("target", p.id + "_iframe");
                    C.style.position = "absolute";
                    A = a.createElement("input");
                    A.setAttribute("id", "input_" + q);
                    A.setAttribute("type", "file");
                    A.setAttribute("accept", t);
                    A.setAttribute("size", 1);
                    B = e(p.settings.browse_button);
                    if (p.features.triggerDialog && B) {
                        b.addEvent(
                            e(p.settings.browse_button),
                            "click",
                            function (D) {
                                if (!A.disabled) {
                                    A.click();
                                }
                                D.preventDefault();
                            },
                            p.id
                        );
                    }
                    b.extend(A.style, {
                        width: "100%",
                        height: "100%",
                        opacity: 0,
                        fontSize: "99px",
                        cursor: "pointer",
                    });
                    b.extend(C.style, { overflow: "hidden" });
                    y = p.settings.shim_bgcolor;
                    if (y) {
                        C.style.background = y;
                    }
                    if (r) {
                        b.extend(A.style, { filter: "alpha(opacity=0)" });
                    }
                    b.addEvent(
                        A,
                        "change",
                        function (G) {
                            var E = G.target,
                                D,
                                F = [],
                                H;
                            if (E.value) {
                                e("form_" + q).style.top = -1048575 + "px";
                                D = E.value.replace(/\\/g, "/");
                                D = D.substring(
                                    D.length,
                                    D.lastIndexOf("/") + 1
                                );
                                F.push(new b.File(q, D));
                                if (!p.features.triggerDialog) {
                                    b.removeAllEvents(C, p.id);
                                } else {
                                    b.removeEvent(B, "click", p.id);
                                }
                                b.removeEvent(A, "change", p.id);
                                v();
                                if (F.length) {
                                    f.trigger("FilesAdded", F);
                                }
                            }
                        },
                        p.id
                    );
                    C.appendChild(A);
                    j.appendChild(C);
                    p.refresh();
                }
                function u() {
                    var y = a.createElement("div");
                    y.innerHTML =
                        '<iframe id="' +
                        p.id +
                        '_iframe" name="' +
                        p.id +
                        '_iframe" src="' +
                        h +
                        ':&quot;&quot;" style="display:none"></iframe>';
                    n = y.firstChild;
                    j.appendChild(n);
                    b.addEvent(
                        n,
                        "load",
                        function (D) {
                            var E = D.target,
                                C,
                                A;
                            if (!k) {
                                return;
                            }
                            try {
                                C =
                                    E.contentWindow.document ||
                                    E.contentDocument ||
                                    d.frames[E.id].document;
                            } catch (B) {
                                p.trigger("Error", {
                                    code: b.SECURITY_ERROR,
                                    message: b.translate("Security error."),
                                    file: k,
                                });
                                return;
                            }
                            A =
                                C.documentElement.innerText ||
                                C.documentElement.textContent;
                            if (A) {
                                k.status = b.DONE;
                                k.loaded = 1025;
                                k.percent = 100;
                                p.trigger("UploadProgress", k);
                                p.trigger("FileUploaded", k, { response: A });
                            }
                        },
                        p.id
                    );
                }
                if (p.settings.container) {
                    j = e(p.settings.container);
                    if (b.getStyle(j, "position") === "static") {
                        j.style.position = "relative";
                    }
                }
                p.bind("UploadFile", function (y, B) {
                    var C, A;
                    if (
                        B.status == b.DONE ||
                        B.status == b.FAILED ||
                        y.state == b.STOPPED
                    ) {
                        return;
                    }
                    C = e("form_" + B.id);
                    A = e("input_" + B.id);
                    A.setAttribute("name", y.settings.file_data_name);
                    C.setAttribute("action", y.settings.url);
                    b.each(
                        b.extend(
                            { name: B.target_name || B.name },
                            y.settings.multipart_params
                        ),
                        function (F, D) {
                            var E = a.createElement("input");
                            b.extend(E, { type: "hidden", name: D, value: F });
                            C.insertBefore(E, C.firstChild);
                        }
                    );
                    k = B;
                    e("form_" + q).style.top = -1048575 + "px";
                    C.submit();
                });
                p.bind("FileUploaded", function (y) {
                    y.refresh();
                });
                p.bind("StateChanged", function (y) {
                    if (y.state == b.STARTED) {
                        u();
                    } else {
                        if (y.state == b.STOPPED) {
                            d.setTimeout(function () {
                                b.removeEvent(n, "load", y.id);
                                if (n.parentNode) {
                                    n.parentNode.removeChild(n);
                                }
                            }, 0);
                        }
                    }
                    b.each(y.files, function (B, A) {
                        if (B.status === b.DONE || B.status === b.FAILED) {
                            var C = e("form_" + B.id);
                            if (C) {
                                C.parentNode.removeChild(C);
                            }
                        }
                    });
                });
                p.bind("Refresh", function (A) {
                    var G, B, C, D, y, H, I, F, E;
                    G = e(A.settings.browse_button);
                    if (G) {
                        y = b.getPos(G, e(A.settings.container));
                        H = b.getSize(G);
                        I = e("form_" + q);
                        F = e("input_" + q);
                        b.extend(I.style, {
                            top: y.y + "px",
                            left: y.x + "px",
                            width: H.w + "px",
                            height: H.h + "px",
                        });
                        if (A.features.triggerDialog) {
                            if (b.getStyle(G, "position") === "static") {
                                b.extend(G.style, { position: "relative" });
                            }
                            E = parseInt(G.style.zIndex, 10);
                            if (isNaN(E)) {
                                E = 0;
                            }
                            b.extend(G.style, { zIndex: E });
                            b.extend(I.style, { zIndex: E - 1 });
                        }
                        C = A.settings.browse_button_hover;
                        D = A.settings.browse_button_active;
                        B = A.features.triggerDialog ? G : I;
                        if (C) {
                            b.addEvent(
                                B,
                                "mouseover",
                                function () {
                                    b.addClass(G, C);
                                },
                                A.id
                            );
                            b.addEvent(
                                B,
                                "mouseout",
                                function () {
                                    b.removeClass(G, C);
                                },
                                A.id
                            );
                        }
                        if (D) {
                            b.addEvent(
                                B,
                                "mousedown",
                                function () {
                                    b.addClass(G, D);
                                },
                                A.id
                            );
                            b.addEvent(
                                a.body,
                                "mouseup",
                                function () {
                                    b.removeClass(G, D);
                                },
                                A.id
                            );
                        }
                    }
                });
                f.bind("FilesRemoved", function (y, B) {
                    var A, C;
                    for (A = 0; A < B.length; A++) {
                        C = e("form_" + B[A].id);
                        if (C) {
                            C.parentNode.removeChild(C);
                        }
                    }
                });
                f.bind("DisableBrowse", function (y, B) {
                    var A = a.getElementById("input_" + q);file
                    if (A) {
                        A.disabled = B;
                    }
                });
                f.bind("Destroy", function (y) {
                    var A,
                        B,
                        C,
                        D = {
                            inputContainer: "form_" + q,
                            inputFile: "input_" + q,
                            browseButton: y.settings.browse_button,
                        };
                    for (A in D) {
                        B = e(D[A]);
                        if (B) {
                            b.removeAllEvents(B, y.id);
                        }
                    }
                    b.removeAllEvents(a.body, y.id);
                    b.each(z, function (F, E) {
                        C = e("form_" + F);
                        if (C) {
                            C.parentNode.removeChild(C);
                        }
                    });
                });
                v();
            });
            g({ success: true });
        },
    });
})(window, document, plupload);
