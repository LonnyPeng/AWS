var system = require('system');

var a = system.args[1], TKK = system.args[2];

console.log(tk(a, TKK));

phantom.exit();

/*
 * 服务于 Google 翻译 tk 值
 */
function b(a, b) {
    var c;

    for (var d = 0; d < b.length - 2; d += 3) {
        c = b.substr(d + 2, 1);
        if ("a" <= c) {
            c = c.charCodeAt(0) - 87;
        } else {
            c = parseInt(c);
        }

        if ("+" == b.substr(d + 1, 1)) {
            c = a >>> c;
        } else {
            c = a << c;
        }

        if ("+" == b.substr(d, 1)) {
            a = a + c & 4294967295;
        } else {
            a = a ^ c;
        }
    }

    return a;
}

/*
 * 获取 Google 翻译 tk 值
 *
 * a 要翻译的内容
 * TKK Google 返回的值
 */
function tk(a, TKK) {
    var e = TKK.split("."), 
        h = parseInt(e[0]) || 0, 
        g = [],
        d = 0,
        c;

    for (var f = 0; f < a.length; f++) {
        c = a.charCodeAt(f);
        if (128 > c) {
            g[d++] = c;
        } else {
            if (2048 > c) {
                g[d++] = c >> 6 | 192;
            } else {
                if (55296 == (c & 64512) 
                    && f + 1 < a.length 
                    && 56320 == (a.charCodeAt(f + 1) & 64512)) {
                    c = 65536 + ((c & 1023) << 10) + (a.charCodeAt(++f) & 1023);
                    g[d++] = c >> 18 | 240;
                    g[d++] = c >> 12 & 63 | 128;
                } else {
                    g[d++] = c >> 12 | 224;
                    g[d++] = c >> 6 & 63 | 128;
                }
            }
            g[d++] = c & 63 | 128;
        }
    }

    a = h;
    for (d = 0; d < g.length; d++) {
        a += g[d];
        a = b(a, "+-a^+6");
    }

    a = b(a, "+-3^+b+-f");
    a ^= parseInt(e[1]) || 0;
    0 > a && (a = (a & 2147483647) + 2147483648);
    a %= 1E6;

    return a.toString() + "." + (a ^ h)
}
