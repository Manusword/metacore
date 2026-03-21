  
/*! xlsx-js.js v0.8.8
 *
 * (C) 2013-2015 SheetJS -- http://sheetjs.com
 * */
!function (e) {
    if ("object" == typeof exports && "undefined" != typeof module) module.exports = e(); else if ("function" == typeof define && define.amd) define([], e); else {
        var f;
        "undefined" != typeof window ? f = window : "undefined" != typeof global ? f = global : "undefined" != typeof self && (f = self), f.JSZip = e()
    }
}(function () {
    var define, module, exports;
    return function e(t, n, r) {
        function s(o, u) {
            if (!n[o]) {
                if (!t[o]) {
                    var a = typeof require == "function" && require;
                    if (!u && a)return a(o, !0);
                    if (i)return i(o, !0);
                    throw new Error("Cannot find module '" + o + "'")
                }
                var f = n[o] = {exports: {}};
                t[o][0].call(f.exports, function (e) {
                    var n = t[o][1][e];
                    return s(n ? n : e)
                }, f, f.exports, e, t, n, r)
            }
            return n[o].exports
        }

        var i = typeof require == "function" && require;
        for (var o = 0; o < r.length; o++)s(r[o]);
        return s
    }({
        1: [function (_dereq_, module, exports) {
            "use strict";
            var _keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
            exports.encode = function (input, utf8) {
                var output = "";
                var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
                var i = 0;
                while (i < input.length) {
                    chr1 = input.charCodeAt(i++);
                    chr2 = input.charCodeAt(i++);
                    chr3 = input.charCodeAt(i++);
                    enc1 = chr1 >> 2;
                    enc2 = (chr1 & 3) << 4 | chr2 >> 4;
                    enc3 = (chr2 & 15) << 2 | chr3 >> 6;
                    enc4 = chr3 & 63;
                    if (isNaN(chr2)) {
                        enc3 = enc4 = 64
                    } else if (isNaN(chr3)) {
                        enc4 = 64
                    }
                    output = output + _keyStr.charAt(enc1) + _keyStr.charAt(enc2) + _keyStr.charAt(enc3) + _keyStr.charAt(enc4)
                }
                return output
            };
            exports.decode = function (input, utf8) {
                var output = "";
                var chr1, chr2, chr3;
                var enc1, enc2, enc3, enc4;
                var i = 0;
                input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
                while (i < input.length) {
                    enc1 = _keyStr.indexOf(input.charAt(i++));
                    enc2 = _keyStr.indexOf(input.charAt(i++));
                    enc3 = _keyStr.indexOf(input.charAt(i++));
                    enc4 = _keyStr.indexOf(input.charAt(i++));
                    chr1 = enc1 << 2 | enc2 >> 4;
                    chr2 = (enc2 & 15) << 4 | enc3 >> 2;
                    chr3 = (enc3 & 3) << 6 | enc4;
                    output = output + String.fromCharCode(chr1);
                    if (enc3 != 64) {
                        output = output + String.fromCharCode(chr2)
                    }
                    if (enc4 != 64) {
                        output = output + String.fromCharCode(chr3)
                    }
                }
                return output
            }
        }, {}],
        2: [function (_dereq_, module, exports) {
            "use strict";
            function CompressedObject() {
                this.compressedSize = 0;
                this.uncompressedSize = 0;
                this.crc32 = 0;
                this.compressionMethod = null;
                this.compressedContent = null
            }

            CompressedObject.prototype = {
                getContent: function () {
                    return null
                }, getCompressedContent: function () {
                    return null
                }
            };
            module.exports = CompressedObject
        }, {}],
        3: [function (_dereq_, module, exports) {
            "use strict";
            exports.STORE = {
                magic: "\x00\x00", compress: function (content) {
                    return content
                }, uncompress: function (content) {
                    return content
                }, compressInputType: null, uncompressInputType: null
            };
            exports.DEFLATE = _dereq_("./flate")
        }, {"./flate": 8}],
        4: [function (_dereq_, module, exports) {
            "use strict";
            var utils = _dereq_("./utils");
            var table = [0, 1996959894, 3993919788, 2567524794, 124634137, 1886057615, 3915621685, 2657392035, 249268274, 2044508324, 3772115230, 2547177864, 162941995, 2125561021, 3887607047, 2428444049, 498536548, 1789927666, 4089016648, 2227061214, 450548861, 1843258603, 4107580753, 2211677639, 325883990, 1684777152, 4251122042, 2321926636, 335633487, 1661365465, 4195302755, 2366115317, 997073096, 1281953886, 3579855332, 2724688242, 1006888145, 1258607687, 3524101629, 2768942443, 901097722, 1119000684, 3686517206, 2898065728, 853044451, 1172266101, 3705015759, 2882616665, 651767980, 1373503546, 3369554304, 3218104598, 565507253, 1454621731, 3485111705, 3099436303, 671266974, 1594198024, 3322730930, 2970347812, 795835527, 1483230225, 3244367275, 3060149565, 1994146192, 31158534, 2563907772, 4023717930, 1907459465, 112637215, 2680153253, 3904427059, 2013776290, 251722036, 2517215374, 3775830040, 2137656763, 141376813, 2439277719, 3865271297, 1802195444, 476864866, 2238001368, 4066508878, 1812370925, 453092731, 2181625025, 4111451223, 1706088902, 314042704, 2344532202, 4240017532, 1658658271, 366619977, 2362670323, 4224994405, 1303535960, 984961486, 2747007092, 3569037538, 1256170817, 1037604311, 2765210733, 3554079995, 1131014506, 879679996, 2909243462, 3663771856, 1141124467, 855842277, 2852801631, 3708648649, 1342533948, 654459306, 3188396048, 3373015174, 1466479909, 544179635, 3110523913, 3462522015, 1591671054, 702138776, 2966460450, 3352799412, 1504918807, 783551873, 3082640443, 3233442989, 3988292384, 2596254646, 62317068, 1957810842, 3939845945, 2647816111, 81470997, 1943803523, 3814918930, 2489596804, 225274430, 2053790376, 3826175755, 2466906013, 167816743, 2097651377, 4027552580, 2265490386, 503444072, 1762050814, 4150417245, 2154129355, 426522225, 1852507879, 4275313526, 2312317920, 282753626, 1742555852, 4189708143, 2394877945, 397917763, 1622183637, 3604390888, 2714866558, 953729732, 1340076626, 3518719985, 2797360999, 1068828381, 1219638859, 3624741850, 2936675148, 906185462, 1090812512, 3747672003, 2825379669, 829329135, 1181335161, 3412177804, 3160834842, 628085408, 1382605366, 3423369109, 3138078467, 570562233, 1426400815, 3317316542, 2998733608, 733239954, 1555261956, 3268935591, 3050360625, 752459403, 1541320221, 2607071920, 3965973030, 1969922972, 40735498, 2617837225, 3943577151, 1913087877, 83908371, 2512341634, 3803740692, 2075208622, 213261112, 2463272603, 3855990285, 2094854071, 198958881, 2262029012, 4057260610, 1759359992, 534414190, 2176718541, 4139329115, 1873836001, 414664567, 2282248934, 4279200368, 1711684554, 285281116, 2405801727, 4167216745, 1634467795, 376229701, 2685067896, 3608007406, 1308918612, 956543938, 2808555105, 3495958263, 1231636301, 1047427035, 2932959818, 3654703836, 1088359270, 936918e3, 2847714899, 3736837829, 1202900863, 817233897, 3183342108, 3401237130, 1404277552, 615818150, 3134207493, 3453421203, 1423857449, 601450431, 3009837614, 3294710456, 1567103746, 711928724, 3020668471, 3272380065, 1510334235, 755167117];
            module.exports = function crc32(input, crc) {
                if (typeof input === "undefined" || !input.length) {
                    return 0
                }
                var isArray = utils.getTypeOf(input) !== "string";
                if (typeof crc == "undefined") {
                    crc = 0
                }
                var x = 0;
                var y = 0;
                var b = 0;
                crc = crc ^ -1;
                for (var i = 0, iTop = input.length; i < iTop; i++) {
                    b = isArray ? input[i] : input.charCodeAt(i);
                    y = (crc ^ b) & 255;
                    x = table[y];
                    crc = crc >>> 8 ^ x
                }
                return crc ^ -1
            }
        }, {"./utils": 21}],
        5: [function (_dereq_, module, exports) {
            "use strict";
            var utils = _dereq_("./utils");

            function DataReader(data) {
                this.data = null;
                this.length = 0;
                this.index = 0
            }

            DataReader.prototype = {
                checkOffset: function (offset) {
                    this.checkIndex(this.index + offset)
                }, checkIndex: function (newIndex) {
                    if (this.length < newIndex || newIndex < 0) {
                        throw new Error("End of data reached (data length = " + this.length + ", asked index = " + newIndex + "). Corrupted zip ?")
                    }
                }, setIndex: function (newIndex) {
                    this.checkIndex(newIndex);
                    this.index = newIndex
                }, skip: function (n) {
                    this.setIndex(this.index + n)
                }, byteAt: function (i) {
                }, readInt: function (size) {
                    var result = 0, i;
                    this.checkOffset(size);
                    for (i = this.index + size - 1; i >= this.index; i--) {
                        result = (result << 8) + this.byteAt(i)
                    }
                    this.index += size;
                    return result
                }, readString: function (size) {
                    return utils.transformTo("string", this.readData(size))
                }, readData: function (size) {
                }, lastIndexOfSignature: function (sig) {
                }, readDate: function () {
                    var dostime = this.readInt(4);
                    return new Date((dostime >> 25 & 127) + 1980, (dostime >> 21 & 15) - 1, dostime >> 16 & 31, dostime >> 11 & 31, dostime >> 5 & 63, (dostime & 31) << 1)
                }
            };
            module.exports = DataReader
        }, {"./utils": 21}],
        6: [function (_dereq_, module, exports) {
            "use strict";
            exports.base64 = false;
            exports.binary = false;
            exports.dir = false;
            exports.createFolders = false;
            exports.date = null;
            exports.compression = null;
            exports.comment = null
        }, {}],
        7: [function (_dereq_, module, exports) {
            "use strict";
            var utils = _dereq_("./utils");
            exports.string2binary = function (str) {
                return utils.string2binary(str)
            };
            exports.string2Uint8Array = function (str) {
                return utils.transformTo("uint8array", str)
            };
            exports.uint8Array2String = function (array) {
                return utils.transformTo("string", array)
            };
            exports.string2Blob = function (str) {
                var buffer = utils.transformTo("arraybuffer", str);
                return utils.arrayBuffer2Blob(buffer)
            };
            exports.arrayBuffer2Blob = function (buffer) {
                return utils.arrayBuffer2Blob(buffer)
            };
            exports.transformTo = function (outputType, input) {
                return utils.transformTo(outputType, input)
            };
            exports.getTypeOf = function (input) {
                return utils.getTypeOf(input)
            };
            exports.checkSupport = function (type) {
                return utils.checkSupport(type)
            };
            exports.MAX_VALUE_16BITS = utils.MAX_VALUE_16BITS;
            exports.MAX_VALUE_32BITS = utils.MAX_VALUE_32BITS;
            exports.pretty = function (str) {
                return utils.pretty(str)
            };
            exports.findCompression = function (compressionMethod) {
                return utils.findCompression(compressionMethod)
            };
            exports.isRegExp = function (object) {
                return utils.isRegExp(object)
            }
        }, {"./utils": 21}],
        8: [function (_dereq_, module, exports) {
            "use strict";
            var USE_TYPEDARRAY = typeof Uint8Array !== "undefined" && typeof Uint16Array !== "undefined" && typeof Uint32Array !== "undefined";
            var pako = _dereq_("pako");
            exports.uncompressInputType = USE_TYPEDARRAY ? "uint8array" : "array";
            exports.compressInputType = USE_TYPEDARRAY ? "uint8array" : "array";
            exports.magic = "\b\x00";
            exports.compress = function (input) {
                return pako.deflateRaw(input)
            };
            exports.uncompress = function (input) {
                return pako.inflateRaw(input)
            }
        }, {pako: 24}],
        9: [function (_dereq_, module, exports) {
            "use strict";
            var base64 = _dereq_("./base64");

            function JSZip(data, options) {
                if (!(this instanceof JSZip))return new JSZip(data, options);
                this.files = {};
                this.comment = null;
                this.root = "";
                if (data) {
                    this.load(data, options)
                }
                this.clone = function () {
                    var newObj = new JSZip;
                    for (var i in this) {
                        if (typeof this[i] !== "function") {
                            newObj[i] = this[i]
                        }
                    }
                    return newObj
                }
            }

            JSZip.prototype = _dereq_("./object");
            JSZip.prototype.load = _dereq_("./load");
            JSZip.support = _dereq_("./support");
            JSZip.defaults = _dereq_("./defaults");
            JSZip.utils = _dereq_("./deprecatedPublicUtils");
            JSZip.base64 = {
                encode: function (input) {
                    return base64.encode(input)
                }, decode: function (input) {
                    return base64.decode(input)
                }
            };
            JSZip.compressions = _dereq_("./compressions");
            module.exports = JSZip
        }, {
            "./base64": 1,
            "./compressions": 3,
            "./defaults": 6,
            "./deprecatedPublicUtils": 7,
            "./load": 10,
            "./object": 13,
            "./support": 17
        }],
        10: [function (_dereq_, module, exports) {
            "use strict";
            var base64 = _dereq_("./base64");
            var ZipEntries = _dereq_("./zipEntries");
            module.exports = function (data, options) {
                var files, zipEntries, i, input;
                options = options || {};
                if (options.base64) {
                    data = base64.decode(data)
                }
                zipEntries = new ZipEntries(data, options);
                files = zipEntries.files;
                for (i = 0; i < files.length; i++) {
                    input = files[i];
                    this.file(input.fileName, input.decompressed, {
                        binary: true,
                        optimizedBinaryString: true,
                        date: input.date,
                        dir: input.dir,
                        comment: input.fileComment.length ? input.fileComment : null,
                        createFolders: options.createFolders
                    })
                }
                if (zipEntries.zipComment.length) {
                    this.comment = zipEntries.zipComment
                }
                return this
            }
        }, {"./base64": 1, "./zipEntries": 22}],
        11: [function (_dereq_, module, exports) {
            (function (Buffer) {
                "use strict";
                module.exports = function (data, encoding) {
                    return new Buffer(data, encoding)
                };
                module.exports.test = function (b) {
                    return Buffer.isBuffer(b)
                }
            }).call(this, typeof Buffer !== "undefined" ? Buffer : undefined)
        }, {}],
        12: [function (_dereq_, module, exports) {
            "use strict";
            var Uint8ArrayReader = _dereq_("./uint8ArrayReader");

            function NodeBufferReader(data) {
                this.data = data;
                this.length = this.data.length;
                this.index = 0
            }

            NodeBufferReader.prototype = new Uint8ArrayReader;
            NodeBufferReader.prototype.readData = function (size) {
                this.checkOffset(size);
                var result = this.data.slice(this.index, this.index + size);
                this.index += size;
                return result
            };
            module.exports = NodeBufferReader
        }, {"./uint8ArrayReader": 18}],
        13: [function (_dereq_, module, exports) {
            "use strict";
            var support = _dereq_("./support");
            var utils = _dereq_("./utils");
            var crc32 = _dereq_("./crc32");
            var signature = _dereq_("./signature");
            var defaults = _dereq_("./defaults");
            var base64 = _dereq_("./base64");
            var compressions = _dereq_("./compressions");
            var CompressedObject = _dereq_("./compressedObject");
            var nodeBuffer = _dereq_("./nodeBuffer");
            var utf8 = _dereq_("./utf8");
            var StringWriter = _dereq_("./stringWriter");
            var Uint8ArrayWriter = _dereq_("./uint8ArrayWriter");
            var getRawData = function (file) {
                if (file._data instanceof CompressedObject) {
                    file._data = file._data.getContent();
                    file.options.binary = true;
                    file.options.base64 = false;
                    if (utils.getTypeOf(file._data) === "uint8array") {
                        var copy = file._data;
                        file._data = new Uint8Array(copy.length);
                        if (copy.length !== 0) {
                            file._data.set(copy, 0)
                        }
                    }
                }
                return file._data
            };
            var getBinaryData = function (file) {
                var result = getRawData(file), type = utils.getTypeOf(result);
                if (type === "string") {
                    if (!file.options.binary) {
                        if (support.nodebuffer) {
                            return nodeBuffer(result, "utf-8")
                        }
                    }
                    return file.asBinary()
                }
                return result
            };
            var dataToString = function (asUTF8) {
                var result = getRawData(this);
                if (result === null || typeof result === "undefined") {
                    return ""
                }
                if (this.options.base64) {
                    result = base64.decode(result)
                }
                if (asUTF8 && this.options.binary) {
                    result = out.utf8decode(result)
                } else {
                    result = utils.transformTo("string", result)
                }
                if (!asUTF8 && !this.options.binary) {
                    result = utils.transformTo("string", out.utf8encode(result))
                }
                return result
            };
            var ZipObject = function (name, data, options) {
                this.name = name;
                this.dir = options.dir;
                this.date = options.date;
                this.comment = options.comment;
                this._data = data;
                this.options = options;
                this._initialMetadata = {dir: options.dir, date: options.date}
            };
            ZipObject.prototype = {
                asText: function () {
                    return dataToString.call(this, true)
                }, asBinary: function () {
                    return dataToString.call(this, false)
                }, asNodeBuffer: function () {
                    var result = getBinaryData(this);
                    return utils.transformTo("nodebuffer", result)
                }, asUint8Array: function () {
                    var result = getBinaryData(this);
                    return utils.transformTo("uint8array", result)
                }, asArrayBuffer: function () {
                    return this.asUint8Array().buffer
                }
            };
            var decToHex = function (dec, bytes) {
                var hex = "", i;
                for (i = 0; i < bytes; i++) {
                    hex += String.fromCharCode(dec & 255);
                    dec = dec >>> 8
                }
                return hex
            };
            var extend = function () {
                var result = {}, i, attr;
                for (i = 0; i < arguments.length; i++) {
                    for (attr in arguments[i]) {
                        if (arguments[i].hasOwnProperty(attr) && typeof result[attr] === "undefined") {
                            result[attr] = arguments[i][attr]
                        }
                    }
                }
                return result
            };
            var prepareFileAttrs = function (o) {
                o = o || {};
                if (o.base64 === true && (o.binary === null || o.binary === undefined)) {
                    o.binary = true
                }
                o = extend(o, defaults);
                o.date = o.date || new Date;
                if (o.compression !== null) o.compression = o.compression.toUpperCase();
                return o
            };
            var fileAdd = function (name, data, o) {
                var dataType = utils.getTypeOf(data), parent;
                o = prepareFileAttrs(o);
                if (o.createFolders && (parent = parentFolder(name))) {
                    folderAdd.call(this, parent, true)
                }
                if (o.dir || data === null || typeof data === "undefined") {
                    o.base64 = false;
                    o.binary = false;
                    data = null
                } else if (dataType === "string") {
                    if (o.binary && !o.base64) {
                        if (o.optimizedBinaryString !== true) {
                            data = utils.string2binary(data)
                        }
                    }
                } else {
                    o.base64 = false;
                    o.binary = true;
                    if (!dataType && !(data instanceof CompressedObject)) {
                        throw new Error("The data of '" + name + "' is in an unsupported format !")
                    }
                    if (dataType === "arraybuffer") {
                        data = utils.transformTo("uint8array", data)
                    }
                }
                var object = new ZipObject(name, data, o);
                this.files[name] = object;
                return object
            };
            var parentFolder = function (path) {
                if (path.slice(-1) == "/") {
                    path = path.substring(0, path.length - 1)
                }
                var lastSlash = path.lastIndexOf("/");
                return lastSlash > 0 ? path.substring(0, lastSlash) : ""
            };
            var folderAdd = function (name, createFolders) {
                if (name.slice(-1) != "/") {
                    name += "/"
                }
                createFolders = typeof createFolders !== "undefined" ? createFolders : false;
                if (!this.files[name]) {
                    fileAdd.call(this, name, null, {dir: true, createFolders: createFolders})
                }
                return this.files[name]
            };
            var generateCompressedObjectFrom = function (file, compression) {
                var result = new CompressedObject, content;
                if (file._data instanceof CompressedObject) {
                    result.uncompressedSize = file._data.uncompressedSize;
                    result.crc32 = file._data.crc32;
                    if (result.uncompressedSize === 0 || file.dir) {
                        compression = compressions["STORE"];
                        result.compressedContent = "";
                        result.crc32 = 0
                    } else if (file._data.compressionMethod === compression.magic) {
                        result.compressedContent = file._data.getCompressedContent()
                    } else {
                        content = file._data.getContent();
                        result.compressedContent = compression.compress(utils.transformTo(compression.compressInputType, content))
                    }
                } else {
                    content = getBinaryData(file);
                    if (!content || content.length === 0 || file.dir) {
                        compression = compressions["STORE"];
                        content = ""
                    }
                    result.uncompressedSize = content.length;
                    result.crc32 = crc32(content);
                    result.compressedContent = compression.compress(utils.transformTo(compression.compressInputType, content))
                }
                result.compressedSize = result.compressedContent.length;
                result.compressionMethod = compression.magic;
                return result
            };
            var generateZipParts = function (name, file, compressedObject, offset) {
                var data = compressedObject.compressedContent, utfEncodedFileName = utils.transformTo("string", utf8.utf8encode(file.name)), comment = file.comment || "", utfEncodedComment = utils.transformTo("string", utf8.utf8encode(comment)), useUTF8ForFileName = utfEncodedFileName.length !== file.name.length, useUTF8ForComment = utfEncodedComment.length !== comment.length, o = file.options, dosTime, dosDate, extraFields = "", unicodePathExtraField = "", unicodeCommentExtraField = "", dir, date;
                if (file._initialMetadata.dir !== file.dir) {
                    dir = file.dir
                } else {
                    dir = o.dir
                }
                if (file._initialMetadata.date !== file.date) {
                    date = file.date
                } else {
                    date = o.date
                }
                dosTime = date.getHours();
                dosTime = dosTime << 6;
                dosTime = dosTime | date.getMinutes();
                dosTime = dosTime << 5;
                dosTime = dosTime | date.getSeconds() / 2;
                dosDate = date.getFullYear() - 1980;
                dosDate = dosDate << 4;
                dosDate = dosDate | date.getMonth() + 1;
                dosDate = dosDate << 5;
                dosDate = dosDate | date.getDate();
                if (useUTF8ForFileName) {
                    unicodePathExtraField = decToHex(1, 1) + decToHex(crc32(utfEncodedFileName), 4) + utfEncodedFileName;
                    extraFields += "up" + decToHex(unicodePathExtraField.length, 2) + unicodePathExtraField
                }
                if (useUTF8ForComment) {
                    unicodeCommentExtraField = decToHex(1, 1) + decToHex(this.crc32(utfEncodedComment), 4) + utfEncodedComment;
                    extraFields += "uc" + decToHex(unicodeCommentExtraField.length, 2) + unicodeCommentExtraField
                }
                var header = "";
                header += "\n\x00";
                header += useUTF8ForFileName || useUTF8ForComment ? "\x00\b" : "\x00\x00";
                header += compressedObject.compressionMethod;
                header += decToHex(dosTime, 2);
                header += decToHex(dosDate, 2);
                header += decToHex(compressedObject.crc32, 4);
                header += decToHex(compressedObject.compressedSize, 4);
                header += decToHex(compressedObject.uncompressedSize, 4);
                header += decToHex(utfEncodedFileName.length, 2);
                header += decToHex(extraFields.length, 2);
                var fileRecord = signature.LOCAL_FILE_HEADER + header + utfEncodedFileName + extraFields;
                var dirRecord = signature.CENTRAL_FILE_HEADER + "\x00" + header + decToHex(utfEncodedComment.length, 2) + "\x00\x00" + "\x00\x00" + (dir === true ? "\x00\x00\x00" : "\x00\x00\x00\x00") + decToHex(offset, 4) + utfEncodedFileName + extraFields + utfEncodedComment;
                return {fileRecord: fileRecord, dirRecord: dirRecord, compressedObject: compressedObject}
            };
            var out = {
                load: function (stream, options) {
                    throw new Error("Load method is not defined. Is the file jszip-load.js included ?")
                }, filter: function (search) {
                    var result = [], filename, relativePath, file, fileClone;
                    for (filename in this.files) {
                        if (!this.files.hasOwnProperty(filename)) {
                            continue
                        }
                        file = this.files[filename];
                        fileClone = new ZipObject(file.name, file._data, extend(file.options));
                        relativePath = filename.slice(this.root.length, filename.length);
                        if (filename.slice(0, this.root.length) === this.root && search(relativePath, fileClone)) {
                            result.push(fileClone)
                        }
                    }
                    return result
                }, file: function (name, data, o) {
                    if (arguments.length === 1) {
                        if (utils.isRegExp(name)) {
                            var regexp = name;
                            return this.filter(function (relativePath, file) {
                                return !file.dir && regexp.test(relativePath)
                            })
                        } else {
                            return this.filter(function (relativePath, file) {
                                    return !file.dir && relativePath === name
                                })[0] || null
                        }
                    } else {
                        name = this.root + name;
                        fileAdd.call(this, name, data, o)
                    }
                    return this
                }, folder: function (arg) {
                    if (!arg) {
                        return this
                    }
                    if (utils.isRegExp(arg)) {
                        return this.filter(function (relativePath, file) {
                            return file.dir && arg.test(relativePath)
                        })
                    }
                    var name = this.root + arg;
                    var newFolder = folderAdd.call(this, name);
                    var ret = this.clone();
                    ret.root = newFolder.name;
                    return ret
                }, remove: function (name) {
                    name = this.root + name;
                    var file = this.files[name];
                    if (!file) {
                        if (name.slice(-1) != "/") {
                            name += "/"
                        }
                        file = this.files[name]
                    }
                    if (file && !file.dir) {
                        delete this.files[name]
                    } else {
                        var kids = this.filter(function (relativePath, file) {
                            return file.name.slice(0, name.length) === name
                        });
                        for (var i = 0; i < kids.length; i++) {
                            delete this.files[kids[i].name]
                        }
                    }
                    return this
                }, generate: function (options) {
                    options = extend(options || {}, {
                        base64: true,
                        compression: "STORE",
                        type: "base64",
                        comment: null
                    });
                    utils.checkSupport(options.type);
                    var zipData = [], localDirLength = 0, centralDirLength = 0, writer, i, utfEncodedComment = utils.transformTo("string", this.utf8encode(options.comment || this.comment || ""));
                    for (var name in this.files) {
                        if (!this.files.hasOwnProperty(name)) {
                            continue
                        }
                        var file = this.files[name];
                        var compressionName = file.options.compression || options.compression.toUpperCase();
                        var compression = compressions[compressionName];
                        if (!compression) {
                            throw new Error(compressionName + " is not a valid compression method !")
                        }
                        var compressedObject = generateCompressedObjectFrom.call(this, file, compression);
                        var zipPart = generateZipParts.call(this, name, file, compressedObject, localDirLength);
                        localDirLength += zipPart.fileRecord.length + compressedObject.compressedSize;
                        centralDirLength += zipPart.dirRecord.length;
                        zipData.push(zipPart)
                    }
                    var dirEnd = "";
                    dirEnd = signature.CENTRAL_DIRECTORY_END + "\x00\x00" + "\x00\x00" + decToHex(zipData.length, 2) + decToHex(zipData.length, 2) + decToHex(centralDirLength, 4) + decToHex(localDirLength, 4) + decToHex(utfEncodedComment.length, 2) + utfEncodedComment;
                    var typeName = options.type.toLowerCase();
                    if (typeName === "uint8array" || typeName === "arraybuffer" || typeName === "blob" || typeName === "nodebuffer") {
                        writer = new Uint8ArrayWriter(localDirLength + centralDirLength + dirEnd.length)
                    } else {
                        writer = new StringWriter(localDirLength + centralDirLength + dirEnd.length)
                    }
                    for (i = 0; i < zipData.length; i++) {
                        writer.append(zipData[i].fileRecord);
                        writer.append(zipData[i].compressedObject.compressedContent)
                    }
                    for (i = 0; i < zipData.length; i++) {
                        writer.append(zipData[i].dirRecord)
                    }
                    writer.append(dirEnd);
                    var zip = writer.finalize();
                    switch (options.type.toLowerCase()) {
                        case"uint8array":
                        case"arraybuffer":
                        case"nodebuffer":
                            return utils.transformTo(options.type.toLowerCase(), zip);
                        case"blob":
                            return utils.arrayBuffer2Blob(utils.transformTo("arraybuffer", zip));
                        case"base64":
                            return options.base64 ? base64.encode(zip) : zip;
                        default:
                            return zip
                    }
                }, crc32: function (input, crc) {
                    return crc32(input, crc)
                }, utf8encode: function (string) {
                    return utils.transformTo("string", utf8.utf8encode(string))
                }, utf8decode: function (input) {
                    return utf8.utf8decode(input)
                }
            };
            module.exports = out
        }, {
            "./base64": 1,
            "./compressedObject": 2,
            "./compressions": 3,
            "./crc32": 4,
            "./defaults": 6,
            "./nodeBuffer": 11,
            "./signature": 14,
            "./stringWriter": 16,
            "./support": 17,
            "./uint8ArrayWriter": 19,
            "./utf8": 20,
            "./utils": 21
        }],
        14: [function (_dereq_, module, exports) {
            "use strict";
            exports.LOCAL_FILE_HEADER = "PK";
            exports.CENTRAL_FILE_HEADER = "PK";
            exports.CENTRAL_DIRECTORY_END = "PK";
            exports.ZIP64_CENTRAL_DIRECTORY_LOCATOR = "PK";
            exports.ZIP64_CENTRAL_DIRECTORY_END = "PK";
            exports.DATA_DESCRIPTOR = "PK\b"
        }, {}],
        15: [function (_dereq_, module, exports) {
            "use strict";
            var DataReader = _dereq_("./dataReader");
            var utils = _dereq_("./utils");

            function StringReader(data, optimizedBinaryString) {
                this.data = data;
                if (!optimizedBinaryString) {
                    this.data = utils.string2binary(this.data)
                }
                this.length = this.data.length;
                this.index = 0
            }

            StringReader.prototype = new DataReader;
            StringReader.prototype.byteAt = function (i) {
                return this.data.charCodeAt(i)
            };
            StringReader.prototype.lastIndexOfSignature = function (sig) {
                return this.data.lastIndexOf(sig)
            };
            StringReader.prototype.readData = function (size) {
                this.checkOffset(size);
                var result = this.data.slice(this.index, this.index + size);
                this.index += size;
                return result
            };
            module.exports = StringReader
        }, {"./dataReader": 5, "./utils": 21}],
        16: [function (_dereq_, module, exports) {
            "use strict";
            var utils = _dereq_("./utils");
            var StringWriter = function () {
                this.data = []
            };
            StringWriter.prototype = {
                append: function (input) {
                    input = utils.transformTo("string", input);
                    this.data.push(input)
                }, finalize: function () {
                    return this.data.join("")
                }
            };
            module.exports = StringWriter
        }, {"./utils": 21}],
        17: [function (_dereq_, module, exports) {
            (function (Buffer) {
                "use strict";
                exports.base64 = true;
                exports.array = true;
                exports.string = true;
                exports.arraybuffer = typeof ArrayBuffer !== "undefined" && typeof Uint8Array !== "undefined";
                exports.nodebuffer = typeof Buffer !== "undefined";
                exports.uint8array = typeof Uint8Array !== "undefined";
                if (typeof ArrayBuffer === "undefined") {
                    exports.blob = false
                } else {
                    var buffer = new ArrayBuffer(0);
                    try {
                        exports.blob = new Blob([buffer], {type: "application/zip"}).size === 0
                    } catch (e) {
                        try {
                            var Builder = window.BlobBuilder || window.WebKitBlobBuilder || window.MozBlobBuilder || window.MSBlobBuilder;
                            var builder = new Builder;
                            builder.append(buffer);
                            exports.blob = builder.getBlob("application/zip").size === 0
                        } catch (e) {
                            exports.blob = false
                        }
                    }
                }
            }).call(this, typeof Buffer !== "undefined" ? Buffer : undefined)
        }, {}],
        18: [function (_dereq_, module, exports) {
            "use strict";
            var DataReader = _dereq_("./dataReader");

            function Uint8ArrayReader(data) {
                if (data) {
                    this.data = data;
                    this.length = this.data.length;
                    this.index = 0
                }
            }

            Uint8ArrayReader.prototype = new DataReader;
            Uint8ArrayReader.prototype.byteAt = function (i) {
                return this.data[i]
            };
            Uint8ArrayReader.prototype.lastIndexOfSignature = function (sig) {
                var sig0 = sig.charCodeAt(0), sig1 = sig.charCodeAt(1), sig2 = sig.charCodeAt(2), sig3 = sig.charCodeAt(3);
                for (var i = this.length - 4; i >= 0; --i) {
                    if (this.data[i] === sig0 && this.data[i + 1] === sig1 && this.data[i + 2] === sig2 && this.data[i + 3] === sig3) {
                        return i
                    }
                }
                return -1
            };
            Uint8ArrayReader.prototype.readData = function (size) {
                this.checkOffset(size);
                if (size === 0) {
                    return new Uint8Array(0)
                }
                var result = this.data.subarray(this.index, this.index + size);
                this.index += size;
                return result
            };
            module.exports = Uint8ArrayReader
        }, {"./dataReader": 5}],
        19: [function (_dereq_, module, exports) {
            "use strict";
            var utils = _dereq_("./utils");
            var Uint8ArrayWriter = function (length) {
                this.data = new Uint8Array(length);
                this.index = 0
            };
            Uint8ArrayWriter.prototype = {
                append: function (input) {
                    if (input.length !== 0) {
                        input = utils.transformTo("uint8array", input);
                        this.data.set(input, this.index);
                        this.index += input.length
                    }
                }, finalize: function () {
                    return this.data
                }
            };
            module.exports = Uint8ArrayWriter
        }, {"./utils": 21}],
        20: [function (_dereq_, module, exports) {
            "use strict";
            var utils = _dereq_("./utils");
            var support = _dereq_("./support");
            var nodeBuffer = _dereq_("./nodeBuffer");
            var _utf8len = new Array(256);
            for (var i = 0; i < 256; i++) {
                _utf8len[i] = i >= 252 ? 6 : i >= 248 ? 5 : i >= 240 ? 4 : i >= 224 ? 3 : i >= 192 ? 2 : 1
            }
            _utf8len[254] = _utf8len[254] = 1;
            var string2buf = function (str) {
                var buf, c, c2, m_pos, i, str_len = str.length, buf_len = 0;
                for (m_pos = 0; m_pos < str_len; m_pos++) {
                    c = str.charCodeAt(m_pos);
                    if ((c & 64512) === 55296 && m_pos + 1 < str_len) {
                        c2 = str.charCodeAt(m_pos + 1);
                        if ((c2 & 64512) === 56320) {
                            c = 65536 + (c - 55296 << 10) + (c2 - 56320);
                            m_pos++
                        }
                    }
                    buf_len += c < 128 ? 1 : c < 2048 ? 2 : c < 65536 ? 3 : 4
                }
                if (support.uint8array) {
                    buf = new Uint8Array(buf_len)
                } else {
                    buf = new Array(buf_len)
                }
                for (i = 0, m_pos = 0; i < buf_len; m_pos++) {
                    c = str.charCodeAt(m_pos);
                    if ((c & 64512) === 55296 && m_pos + 1 < str_len) {
                        c2 = str.charCodeAt(m_pos + 1);
                        if ((c2 & 64512) === 56320) {
                            c = 65536 + (c - 55296 << 10) + (c2 - 56320);
                            m_pos++
                        }
                    }
                    if (c < 128) {
                        buf[i++] = c
                    } else if (c < 2048) {
                        buf[i++] = 192 | c >>> 6;
                        buf[i++] = 128 | c & 63
                    } else if (c < 65536) {
                        buf[i++] = 224 | c >>> 12;
                        buf[i++] = 128 | c >>> 6 & 63;
                        buf[i++] = 128 | c & 63
                    } else {
                        buf[i++] = 240 | c >>> 18;
                        buf[i++] = 128 | c >>> 12 & 63;
                        buf[i++] = 128 | c >>> 6 & 63;
                        buf[i++] = 128 | c & 63
                    }
                }
                return buf
            };
            var utf8border = function (buf, max) {
                var pos;
                max = max || buf.length;
                if (max > buf.length) {
                    max = buf.length
                }
                pos = max - 1;
                while (pos >= 0 && (buf[pos] & 192) === 128) {
                    pos--
                }
                if (pos < 0) {
                    return max
                }
                if (pos === 0) {
                    return max
                }
                return pos + _utf8len[buf[pos]] > max ? pos : max
            };
            var buf2string = function (buf) {
                var str, i, out, c, c_len;
                var len = buf.length;
                var utf16buf = new Array(len * 2);
                for (out = 0, i = 0; i < len;) {
                    c = buf[i++];
                    if (c < 128) {
                        utf16buf[out++] = c;
                        continue
                    }
                    c_len = _utf8len[c];
                    if (c_len > 4) {
                        utf16buf[out++] = 65533;
                        i += c_len - 1;
                        continue
                    }
                    c &= c_len === 2 ? 31 : c_len === 3 ? 15 : 7;
                    while (c_len > 1 && i < len) {
                        c = c << 6 | buf[i++] & 63;
                        c_len--
                    }
                    if (c_len > 1) {
                        utf16buf[out++] = 65533;
                        continue
                    }
                    if (c < 65536) {
                        utf16buf[out++] = c
                    } else {
                        c -= 65536;
                        utf16buf[out++] = 55296 | c >> 10 & 1023;
                        utf16buf[out++] = 56320 | c & 1023
                    }
                }
                if (utf16buf.length !== out) {
                    if (utf16buf.subarray) {
                        utf16buf = utf16buf.subarray(0, out)
                    } else {
                        utf16buf.length = out
                    }
                }
                return utils.applyFromCharCode(utf16buf)
            };
            exports.utf8encode = function utf8encode(str) {
                if (support.nodebuffer) {
                    return nodeBuffer(str, "utf-8")
                }
                return string2buf(str)
            };
            exports.utf8decode = function utf8decode(buf) {
                if (support.nodebuffer) {
                    return utils.transformTo("nodebuffer", buf).toString("utf-8")
                }
                buf = utils.transformTo(support.uint8array ? "uint8array" : "array", buf);
                var result = [], k = 0, len = buf.length, chunk = 65536;
                while (k < len) {
                    var nextBoundary = utf8border(buf, Math.min(k + chunk, len));
                    if (support.uint8array) {
                        result.push(buf2string(buf.subarray(k, nextBoundary)))
                    } else {
                        result.push(buf2string(buf.slice(k, nextBoundary)))
                    }
                    k = nextBoundary
                }
                return result.join("")
            }
        }, {"./nodeBuffer": 11, "./support": 17, "./utils": 21}],
        21: [function (_dereq_, module, exports) {
            "use strict";
            var support = _dereq_("./support");
            var compressions = _dereq_("./compressions");
            var nodeBuffer = _dereq_("./nodeBuffer");
            exports.string2binary = function (str) {
                var result = "";
                for (var i = 0; i < str.length; i++) {
                    result += String.fromCharCode(str.charCodeAt(i) & 255)
                }
                return result
            };
            exports.arrayBuffer2Blob = function (buffer) {
                exports.checkSupport("blob");
                try {
                    return new Blob([buffer], {type: "application/zip"})
                } catch (e) {
                    try {
                        var Builder = window.BlobBuilder || window.WebKitBlobBuilder || window.MozBlobBuilder || window.MSBlobBuilder;
                        var builder = new Builder;
                        builder.append(buffer);
                        return builder.getBlob("application/zip")
                    } catch (e) {
                        throw new Error("Bug : can't construct the Blob.")
                    }
                }
            };
            function identity(input) {
                return input
            }

            function stringToArrayLike(str, array) {
                for (var i = 0; i < str.length; ++i) {
                    array[i] = str.charCodeAt(i) & 255
                }
                return array
            }

            function arrayLikeToString(array) {
                var chunk = 65536;
                var result = [], len = array.length, type = exports.getTypeOf(array), k = 0, canUseApply = true;
                try {
                    switch (type) {
                        case"uint8array":
                            String.fromCharCode.apply(null, new Uint8Array(0));
                            break;
                        case"nodebuffer":
                            String.fromCharCode.apply(null, nodeBuffer(0));
                            break
                    }
                } catch (e) {
                    canUseApply = false
                }
                if (!canUseApply) {
                    var resultStr = "";
                    for (var i = 0; i < array.length; i++) {
                        resultStr += String.fromCharCode(array[i])
                    }
                    return resultStr
                }
                while (k < len && chunk > 1) {
                    try {
                        if (type === "array" || type === "nodebuffer") {
                            result.push(String.fromCharCode.apply(null, array.slice(k, Math.min(k + chunk, len))))
                        } else {
                            result.push(String.fromCharCode.apply(null, array.subarray(k, Math.min(k + chunk, len))))
                        }
                        k += chunk
                    } catch (e) {
                        chunk = Math.floor(chunk / 2)
                    }
                }
                return result.join("")
            }

            exports.applyFromCharCode = arrayLikeToString;
            function arrayLikeToArrayLike(arrayFrom, arrayTo) {
                for (var i = 0; i < arrayFrom.length; i++) {
                    arrayTo[i] = arrayFrom[i]
                }
                return arrayTo
            }

            var transform = {};
            transform["string"] = {
                string: identity, array: function (input) {
                    return stringToArrayLike(input, new Array(input.length))
                }, arraybuffer: function (input) {
                    return transform["string"]["uint8array"](input).buffer
                }, uint8array: function (input) {
                    return stringToArrayLike(input, new Uint8Array(input.length))
                }, nodebuffer: function (input) {
                    return stringToArrayLike(input, nodeBuffer(input.length))
                }
            };
            transform["array"] = {
                string: arrayLikeToString, array: identity, arraybuffer: function (input) {
                    return new Uint8Array(input).buffer
                }, uint8array: function (input) {
                    return new Uint8Array(input)
                }, nodebuffer: function (input) {
                    return nodeBuffer(input)
                }
            };
            transform["arraybuffer"] = {
                string: function (input) {
                    return arrayLikeToString(new Uint8Array(input))
                }, array: function (input) {
                    return arrayLikeToArrayLike(new Uint8Array(input), new Array(input.byteLength))
                }, arraybuffer: identity, uint8array: function (input) {
                    return new Uint8Array(input)
                }, nodebuffer: function (input) {
                    return nodeBuffer(new Uint8Array(input))
                }
            };
            transform["uint8array"] = {
                string: arrayLikeToString, array: function (input) {
                    return arrayLikeToArrayLike(input, new Array(input.length))
                }, arraybuffer: function (input) {
                    return input.buffer
                }, uint8array: identity, nodebuffer: function (input) {
                    return nodeBuffer(input)
                }
            };
            transform["nodebuffer"] = {
                string: arrayLikeToString, array: function (input) {
                    return arrayLikeToArrayLike(input, new Array(input.length))
                }, arraybuffer: function (input) {
                    return transform["nodebuffer"]["uint8array"](input).buffer
                }, uint8array: function (input) {
                    return arrayLikeToArrayLike(input, new Uint8Array(input.length))
                }, nodebuffer: identity
            };
            exports.transformTo = function (outputType, input) {
                if (!input) {
                    input = ""
                }
                if (!outputType) {
                    return input
                }
                exports.checkSupport(outputType);
                var inputType = exports.getTypeOf(input);
                var result = transform[inputType][outputType](input);
                return result
            };
            exports.getTypeOf = function (input) {
                if (typeof input === "string") {
                    return "string"
                }
                if (Object.prototype.toString.call(input) === "[object Array]") {
                    return "array"
                }
                if (support.nodebuffer && nodeBuffer.test(input)) {
                    return "nodebuffer"
                }
                if (support.uint8array && input instanceof Uint8Array) {
                    return "uint8array"
                }
                if (support.arraybuffer && input instanceof ArrayBuffer) {
                    return "arraybuffer"
                }
            };
            exports.checkSupport = function (type) {
                var supported = support[type.toLowerCase()];
                if (!supported) {
                    throw new Error(type + " is not supported by this browser")
                }
            };
            exports.MAX_VALUE_16BITS = 65535;
            exports.MAX_VALUE_32BITS = -1;
            exports.pretty = function (str) {
                var res = "", code, i;
                for (i = 0; i < (str || "").length; i++) {
                    code = str.charCodeAt(i);
                    res += "\\x" + (code < 16 ? "0" : "") + code.toString(16).toUpperCase()
                }
                return res
            };
            exports.findCompression = function (compressionMethod) {
                for (var method in compressions) {
                    if (!compressions.hasOwnProperty(method)) {
                        continue
                    }
                    if (compressions[method].magic === compressionMethod) {
                        return compressions[method]
                    }
                }
                return null
            };
            exports.isRegExp = function (object) {
                return Object.prototype.toString.call(object) === "[object RegExp]"
            }
        }, {"./compressions": 3, "./nodeBuffer": 11, "./support": 17}],
        22: [function (_dereq_, module, exports) {
            "use strict";
            var StringReader = _dereq_("./stringReader");
            var NodeBufferReader = _dereq_("./nodeBufferReader");
            var Uint8ArrayReader = _dereq_("./uint8ArrayReader");
            var utils = _dereq_("./utils");
            var sig = _dereq_("./signature");
            var ZipEntry = _dereq_("./zipEntry");
            var support = _dereq_("./support");
            var jszipProto = _dereq_("./object");

            function ZipEntries(data, loadOptions) {
                this.files = [];
                this.loadOptions = loadOptions;
                if (data) {
                    this.load(data)
                }
            }

            ZipEntries.prototype = {
                checkSignature: function (expectedSignature) {
                    var signature = this.reader.readString(4);
                    if (signature !== expectedSignature) {
                        throw new Error("Corrupted zip or bug : unexpected signature " + "(" + utils.pretty(signature) + ", expected " + utils.pretty(expectedSignature) + ")")
                    }
                }, readBlockEndOfCentral: function () {
                    this.diskNumber = this.reader.readInt(2);
                    this.diskWithCentralDirStart = this.reader.readInt(2);
                    this.centralDirRecordsOnThisDisk = this.reader.readInt(2);
                    this.centralDirRecords = this.reader.readInt(2);
                    this.centralDirSize = this.reader.readInt(4);
                    this.centralDirOffset = this.reader.readInt(4);
                    this.zipCommentLength = this.reader.readInt(2);
                    this.zipComment = this.reader.readString(this.zipCommentLength);
                    this.zipComment = jszipProto.utf8decode(this.zipComment)
                }, readBlockZip64EndOfCentral: function () {
                    this.zip64EndOfCentralSize = this.reader.readInt(8);
                    this.versionMadeBy = this.reader.readString(2);
                    this.versionNeeded = this.reader.readInt(2);
                    this.diskNumber = this.reader.readInt(4);
                    this.diskWithCentralDirStart = this.reader.readInt(4);
                    this.centralDirRecordsOnThisDisk = this.reader.readInt(8);
                    this.centralDirRecords = this.reader.readInt(8);
                    this.centralDirSize = this.reader.readInt(8);
                    this.centralDirOffset = this.reader.readInt(8);
                    this.zip64ExtensibleData = {};
                    var extraDataSize = this.zip64EndOfCentralSize - 44, index = 0, extraFieldId, extraFieldLength, extraFieldValue;
                    while (index < extraDataSize) {
                        extraFieldId = this.reader.readInt(2);
                        extraFieldLength = this.reader.readInt(4);
                        extraFieldValue = this.reader.readString(extraFieldLength);
                        this.zip64ExtensibleData[extraFieldId] = {
                            id: extraFieldId,
                            length: extraFieldLength,
                            value: extraFieldValue
                        }
                    }
                }, readBlockZip64EndOfCentralLocator: function () {
                    this.diskWithZip64CentralDirStart = this.reader.readInt(4);
                    this.relativeOffsetEndOfZip64CentralDir = this.reader.readInt(8);
                    this.disksCount = this.reader.readInt(4);
                    if (this.disksCount > 1) {
                        throw new Error("Multi-volumes zip are not supported")
                    }
                }, readLocalFiles: function () {
                    var i, file;
                    for (i = 0; i < this.files.length; i++) {
                        file = this.files[i];
                        this.reader.setIndex(file.localHeaderOffset);
                        this.checkSignature(sig.LOCAL_FILE_HEADER);
                        file.readLocalPart(this.reader);
                        file.handleUTF8()
                    }
                }, readCentralDir: function () {
                    var file;
                    this.reader.setIndex(this.centralDirOffset);
                    while (this.reader.readString(4) === sig.CENTRAL_FILE_HEADER) {
                        file = new ZipEntry({zip64: this.zip64}, this.loadOptions);
                        file.readCentralPart(this.reader);
                        this.files.push(file)
                    }
                }, readEndOfCentral: function () {
                    var offset = this.reader.lastIndexOfSignature(sig.CENTRAL_DIRECTORY_END);
                    if (offset === -1) {
                        throw new Error("Corrupted zip : can't find end of central directory")
                    }
                    this.reader.setIndex(offset);
                    this.checkSignature(sig.CENTRAL_DIRECTORY_END);
                    this.readBlockEndOfCentral();
                    if (this.diskNumber === utils.MAX_VALUE_16BITS || this.diskWithCentralDirStart === utils.MAX_VALUE_16BITS || this.centralDirRecordsOnThisDisk === utils.MAX_VALUE_16BITS || this.centralDirRecords === utils.MAX_VALUE_16BITS || this.centralDirSize === utils.MAX_VALUE_32BITS || this.centralDirOffset === utils.MAX_VALUE_32BITS) {
                        this.zip64 = true;
                        offset = this.reader.lastIndexOfSignature(sig.ZIP64_CENTRAL_DIRECTORY_LOCATOR);
                        if (offset === -1) {
                            throw new Error("Corrupted zip : can't find the ZIP64 end of central directory locator")
                        }
                        this.reader.setIndex(offset);
                        this.checkSignature(sig.ZIP64_CENTRAL_DIRECTORY_LOCATOR);
                        this.readBlockZip64EndOfCentralLocator();
                        this.reader.setIndex(this.relativeOffsetEndOfZip64CentralDir);
                        this.checkSignature(sig.ZIP64_CENTRAL_DIRECTORY_END);
                        this.readBlockZip64EndOfCentral()
                    }
                }, prepareReader: function (data) {
                    var type = utils.getTypeOf(data);
                    if (type === "string" && !support.uint8array) {
                        this.reader = new StringReader(data, this.loadOptions.optimizedBinaryString)
                    } else if (type === "nodebuffer") {
                        this.reader = new NodeBufferReader(data)
                    } else {
                        this.reader = new Uint8ArrayReader(utils.transformTo("uint8array", data))
                    }
                }, load: function (data) {
                    this.prepareReader(data);
                    this.readEndOfCentral();
                    this.readCentralDir();
                    this.readLocalFiles()
                }
            };
            module.exports = ZipEntries
        }, {
            "./nodeBufferReader": 12,
            "./object": 13,
            "./signature": 14,
            "./stringReader": 15,
            "./support": 17,
            "./uint8ArrayReader": 18,
            "./utils": 21,
            "./zipEntry": 23
        }],
        23: [function (_dereq_, module, exports) {
            "use strict";
            var StringReader = _dereq_("./stringReader");
            var utils = _dereq_("./utils");
            var CompressedObject = _dereq_("./compressedObject");
            var jszipProto = _dereq_("./object");

            function ZipEntry(options, loadOptions) {
                this.options = options;
                this.loadOptions = loadOptions
            }

            ZipEntry.prototype = {
                isEncrypted: function () {
                    return (this.bitFlag & 1) === 1
                }, useUTF8: function () {
                    return (this.bitFlag & 2048) === 2048
                }, prepareCompressedContent: function (reader, from, length) {
                    return function () {
                        var previousIndex = reader.index;
                        reader.setIndex(from);
                        var compressedFileData = reader.readData(length);
                        reader.setIndex(previousIndex);
                        return compressedFileData
                    }
                }, prepareContent: function (reader, from, length, compression, uncompressedSize) {
                    return function () {
                        var compressedFileData = utils.transformTo(compression.uncompressInputType, this.getCompressedContent());
                        var uncompressedFileData = compression.uncompress(compressedFileData);
                        if (uncompressedFileData.length !== uncompressedSize) {
                            throw new Error("Bug : uncompressed data size mismatch")
                        }
                        return uncompressedFileData
                    }
                }, readLocalPart: function (reader) {
                    var compression, localExtraFieldsLength;
                    reader.skip(22);
                    this.fileNameLength = reader.readInt(2);
                    localExtraFieldsLength = reader.readInt(2);
                    this.fileName = reader.readString(this.fileNameLength);
                    reader.skip(localExtraFieldsLength);
                    if (this.compressedSize == -1 || this.uncompressedSize == -1) {
                        throw new Error("Bug or corrupted zip : didn't get enough informations from the central directory " + "(compressedSize == -1 || uncompressedSize == -1)")
                    }
                    compression = utils.findCompression(this.compressionMethod);
                    if (compression === null) {
                        throw new Error("Corrupted zip : compression " + utils.pretty(this.compressionMethod) + " unknown (inner file : " + this.fileName + ")")
                    }
                    this.decompressed = new CompressedObject;
                    this.decompressed.compressedSize = this.compressedSize;
                    this.decompressed.uncompressedSize = this.uncompressedSize;
                    this.decompressed.crc32 = this.crc32;
                    this.decompressed.compressionMethod = this.compressionMethod;
                    this.decompressed.getCompressedContent = this.prepareCompressedContent(reader, reader.index, this.compressedSize, compression);
                    this.decompressed.getContent = this.prepareContent(reader, reader.index, this.compressedSize, compression, this.uncompressedSize);
                    if (this.loadOptions.checkCRC32) {
                        this.decompressed = utils.transformTo("string", this.decompressed.getContent());
                        if (jszipProto.crc32(this.decompressed) !== this.crc32) {
                            throw new Error("Corrupted zip : CRC32 mismatch")
                        }
                    }
                }, readCentralPart: function (reader) {
                    this.versionMadeBy = reader.readString(2);
                    this.versionNeeded = reader.readInt(2);
                    this.bitFlag = reader.readInt(2);
                    this.compressionMethod = reader.readString(2);
                    this.date = reader.readDate();
                    this.crc32 = reader.readInt(4);
                    this.compressedSize = reader.readInt(4);
                    this.uncompressedSize = reader.readInt(4);
                    this.fileNameLength = reader.readInt(2);
                    this.extraFieldsLength = reader.readInt(2);
                    this.fileCommentLength = reader.readInt(2);
                    this.diskNumberStart = reader.readInt(2);
                    this.internalFileAttributes = reader.readInt(2);
                    this.externalFileAttributes = reader.readInt(4);
                    this.localHeaderOffset = reader.readInt(4);
                    if (this.isEncrypted()) {
                        throw new Error("Encrypted zip are not supported")
                    }
                    this.fileName = reader.readString(this.fileNameLength);
                    this.readExtraFields(reader);
                    this.parseZIP64ExtraField(reader);
                    this.fileComment = reader.readString(this.fileCommentLength);
                    this.dir = this.externalFileAttributes & 16 ? true : false
                }, parseZIP64ExtraField: function (reader) {
                    if (!this.extraFields[1]) {
                        return
                    }
                    var extraReader = new StringReader(this.extraFields[1].value);
                    if (this.uncompressedSize === utils.MAX_VALUE_32BITS) {
                        this.uncompressedSize = extraReader.readInt(8)
                    }
                    if (this.compressedSize === utils.MAX_VALUE_32BITS) {
                        this.compressedSize = extraReader.readInt(8)
                    }
                    if (this.localHeaderOffset === utils.MAX_VALUE_32BITS) {
                        this.localHeaderOffset = extraReader.readInt(8)
                    }
                    if (this.diskNumberStart === utils.MAX_VALUE_32BITS) {
                        this.diskNumberStart = extraReader.readInt(4)
                    }
                }, readExtraFields: function (reader) {
                    var start = reader.index, extraFieldId, extraFieldLength, extraFieldValue;
                    this.extraFields = this.extraFields || {};
                    while (reader.index < start + this.extraFieldsLength) {
                        extraFieldId = reader.readInt(2);
                        extraFieldLength = reader.readInt(2);
                        extraFieldValue = reader.readString(extraFieldLength);
                        this.extraFields[extraFieldId] = {
                            id: extraFieldId,
                            length: extraFieldLength,
                            value: extraFieldValue
                        }
                    }
                }, handleUTF8: function () {
                    if (this.useUTF8()) {
                        this.fileName = jszipProto.utf8decode(this.fileName);
                        this.fileComment = jszipProto.utf8decode(this.fileComment)
                    } else {
                        var upath = this.findExtraFieldUnicodePath();
                        if (upath !== null) {
                            this.fileName = upath
                        }
                        var ucomment = this.findExtraFieldUnicodeComment();
                        if (ucomment !== null) {
                            this.fileComment = ucomment
                        }
                    }
                }, findExtraFieldUnicodePath: function () {
                    var upathField = this.extraFields[28789];
                    if (upathField) {
                        var extraReader = new StringReader(upathField.value);
                        if (extraReader.readInt(1) !== 1) {
                            return null
                        }
                        if (jszipProto.crc32(this.fileName) !== extraReader.readInt(4)) {
                            return null
                        }
                        return jszipProto.utf8decode(extraReader.readString(upathField.length - 5))
                    }
                    return null
                }, findExtraFieldUnicodeComment: function () {
                    var ucommentField = this.extraFields[25461];
                    if (ucommentField) {
                        var extraReader = new StringReader(ucommentField.value);
                        if (extraReader.readInt(1) !== 1) {
                            return null
                        }
                        if (jszipProto.crc32(this.fileComment) !== extraReader.readInt(4)) {
                            return null
                        }
                        return jszipProto.utf8decode(extraReader.readString(ucommentField.length - 5))
                    }
                    return null
                }
            };
            module.exports = ZipEntry
        }, {"./compressedObject": 2, "./object": 13, "./stringReader": 15, "./utils": 21}],
        24: [function (_dereq_, module, exports) {
            "use strict";
            var assign = _dereq_("./lib/utils/common").assign;
            var deflate = _dereq_("./lib/deflate");
            var inflate = _dereq_("./lib/inflate");
            var constants = _dereq_("./lib/zlib/constants");
            var pako = {};
            assign(pako, deflate, inflate, constants);
            module.exports = pako
        }, {"./lib/deflate": 25, "./lib/inflate": 26, "./lib/utils/common": 27, "./lib/zlib/constants": 30}],
        25: [function (_dereq_, module, exports) {
            "use strict";
            var zlib_deflate = _dereq_("./zlib/deflate.js");
            var utils = _dereq_("./utils/common");
            var strings = _dereq_("./utils/strings");
            var msg = _dereq_("./zlib/messages");
            var zstream = _dereq_("./zlib/zstream");
            var Z_NO_FLUSH = 0;
            var Z_FINISH = 4;
            var Z_OK = 0;
            var Z_STREAM_END = 1;
            var Z_DEFAULT_COMPRESSION = -1;
            var Z_DEFAULT_STRATEGY = 0;
            var Z_DEFLATED = 8;
            var Deflate = function (options) {
                this.options = utils.assign({
                    level: Z_DEFAULT_COMPRESSION,
                    method: Z_DEFLATED,
                    chunkSize: 16384,
                    windowBits: 15,
                    memLevel: 8,
                    strategy: Z_DEFAULT_STRATEGY,
                    to: ""
                }, options || {});
                var opt = this.options;
                if (opt.raw && opt.windowBits > 0) {
                    opt.windowBits = -opt.windowBits
                } else if (opt.gzip && opt.windowBits > 0 && opt.windowBits < 16) {
                    opt.windowBits += 16
                }
                this.err = 0;
                this.msg = "";
                this.ended = false;
                this.chunks = [];
                this.strm = new zstream;
                this.strm.avail_out = 0;
                var status = zlib_deflate.deflateInit2(this.strm, opt.level, opt.method, opt.windowBits, opt.memLevel, opt.strategy);
                if (status !== Z_OK) {
                    throw new Error(msg[status])
                }
                if (opt.header) {
                    zlib_deflate.deflateSetHeader(this.strm, opt.header)
                }
            };
            Deflate.prototype.push = function (data, mode) {
                var strm = this.strm;
                var chunkSize = this.options.chunkSize;
                var status, _mode;
                if (this.ended) {
                    return false
                }
                _mode = mode === ~~mode ? mode : mode === true ? Z_FINISH : Z_NO_FLUSH;
                if (typeof data === "string") {
                    strm.input = strings.string2buf(data)
                } else {
                    strm.input = data
                }
                strm.next_in = 0;
                strm.avail_in = strm.input.length;
                do {
                    if (strm.avail_out === 0) {
                        strm.output = new utils.Buf8(chunkSize);
                        strm.next_out = 0;
                        strm.avail_out = chunkSize
                    }
