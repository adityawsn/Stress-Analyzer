import sys
import base64
import io

import matplotlib
matplotlib.use('Agg')
import matplotlib.pyplot as plt
import numpy as np


# def trapmf(x, a, b, c, d):
#     x = np.asarray(x, dtype=float)
#     out = np.zeros_like(x, dtype=float)
#     left = (x - a) / (b - a + 1e-6)
#     right = (d - x) / (d - c + 1e-6)
#     out = np.maximum(np.minimum(np.minimum(left, 1), right), 0)
#     return out

def trapmf(x, a, b, c, d):
    x = np.asarray(x, dtype=float)
    y = np.zeros_like(x, dtype=float)

    if a == b:
        y[x <= b] = 1
    else:
        idx = (x >= a) & (x < b)
        y[idx] = (x[idx] - a) / (b - a)

    idx = (x >= b) & (x <= c)
    y[idx] = 1

    if c == d:
        y[x >= c] = 1
    else:
        idx = (x > c) & (x <= d)
        y[idx] = (d - x[idx]) / (d - c)

    return y


def trimf(x, a, b, c):
    x = np.asarray(x, dtype=float)
    left = (x - a) / (b - a + 1e-6)
    right = (c - x) / (c - b + 1e-6)
    out = np.maximum(np.minimum(left, right), 0)
    return out


def z_rendah(alpha):
    return 50 - 20 * alpha


def z_sedang(alpha):
    return 30 + 20 * alpha


def z_tinggi(alpha):
    return 50 + 20 * alpha


def fuzzify_tps(x):
    rendah = trapmf(x, 0, 0, 30, 50)
    sedang = trimf(x, 30, 50, 70)
    tinggi = trapmf(x, 50, 70, 100, 100)
    return rendah, sedang, tinggi

def fuzzify_mw(x):
    buruk = trapmf(x, 0, 0, 30, 50)
    sedang = trimf(x, 30, 50, 70)
    baik = trapmf(x, 50, 70, 100, 100)
    return buruk, sedang, baik


def hitung_tsukamoto(tps, mw):
    tps_rendah, tps_sedang, tps_tinggi = fuzzify_tps(tps)
    mw_buruk, mw_cukup, mw_baik = fuzzify_mw(mw)
    rules = [
        min(tps_rendah, mw_buruk),
        min(tps_rendah, mw_cukup),
        min(tps_rendah, mw_baik),
        min(tps_sedang, mw_buruk),
        min(tps_sedang, mw_cukup),
        min(tps_sedang, mw_baik),
        min(tps_tinggi, mw_buruk),
        min(tps_tinggi, mw_cukup),
        min(tps_tinggi, mw_baik),
    ]
    z_values = [
        z_sedang(rules[0]),
        z_rendah(rules[1]),
        z_rendah(rules[2]),
        z_tinggi(rules[3]),
        z_sedang(rules[4]),
        z_rendah(rules[5]),
        z_tinggi(rules[6]),
        z_tinggi(rules[7]),
        z_sedang(rules[8]),
    ]
    alpha_sum = sum(rules)
    if alpha_sum == 0:
        value = 0.0
    else:
        value = sum(r * z for r, z in zip(rules, z_values)) / alpha_sum
    return round(value, 2)


def hitung_mamdani(tps, mw):
    tps_rendah, tps_sedang, tps_tinggi = fuzzify_tps(tps)
    mw_buruk, mw_cukup, mw_baik = fuzzify_mw(mw)
    rules = [
        min(tps_rendah, mw_buruk),
        min(tps_rendah, mw_cukup),
        min(tps_rendah, mw_baik),
        min(tps_sedang, mw_buruk),
        min(tps_sedang, mw_cukup),
        min(tps_sedang, mw_baik),
        min(tps_tinggi, mw_buruk),
        min(tps_tinggi, mw_cukup),
        min(tps_tinggi, mw_baik ),
    ]
    output_rendah = max(rules[1], rules[2], rules[5])
    output_sedang = max(rules[0], rules[4], rules[8])
    output_tinggi = max(rules[3], rules[6], rules[7])

    x = np.linspace(0, 100, 501)
    rendah = trapmf(x, 0, 0, 30, 50)
    sedang = trimf(x, 30, 50, 70)
    tinggi = trapmf(x, 50, 70, 100, 100)
    aggregated = np.maximum.reduce([
        np.minimum(output_rendah, rendah),
        np.minimum(output_sedang, sedang),
        np.minimum(output_tinggi, tinggi)
    ])
    numerator = np.sum(x * aggregated)
    denominator = np.sum(aggregated)
    value = 0.0 if denominator == 0 else numerator / denominator
    return round(float(value), 2)


def plot_comparison(tps, mw):
    tsukamoto = hitung_tsukamoto(tps, mw)
    mamdani = hitung_mamdani(tps, mw)
    x = np.linspace(0, 100, 501)
    rendah = trapmf(x, 0, 0, 30, 50)
    sedang = trimf(x, 30, 50, 70)
    tinggi = trapmf(x, 50, 70, 100, 100)

    fig, ax = plt.subplots(figsize=(12, 6))
    ax.plot(x, rendah, label='Rendah', color='#1f77b4')
    ax.plot(x, sedang, label='Sedang', color='#ff7f0e')
    ax.plot(x, tinggi, label='Tinggi', color='#2ca02c')
    ax.axvline(tsukamoto, color='#9467bd', linestyle='--', linewidth=2, label=f'Tsukamoto = {tsukamoto}')
    ax.axvline(mamdani, color='#d62728', linestyle=':', linewidth=2, label=f'Mamdani = {mamdani}')

    ax.fill_between(x, 0, sedang, where=(x >= 30) & (x <= 70), color='orange', alpha=0.08)
    ax.set_xlim(0, 100)
    ax.set_ylim(0, 1.05)
    ax.set_title('Fuzzy Tsukamoto vs Fuzzy Mamdani', fontsize=16, weight='bold')
    ax.set_xlabel('Nilai Z')
    ax.set_ylabel('Derajat Keanggotaan')
    ax.grid(alpha=0.3)
    ax.legend(loc='upper right', fontsize=12)

    buf = io.BytesIO()
    fig.tight_layout()
    fig.savefig(buf, format='png', dpi=120, bbox_inches='tight')
    plt.close(fig)
    buf.seek(0)
    sys.stdout.buffer.write(base64.b64encode(buf.getvalue()))


if __name__ == '__main__':
    if len(sys.argv) != 3:
        print('Usage: python plot_comparison.py <tps> <mw>', file=sys.stderr)
        sys.exit(1)
    try:
        tps = float(sys.argv[1])
        mw = float(sys.argv[2])
    except ValueError:
        print('Invalid numeric value for TPS or MW', file=sys.stderr)
        sys.exit(1)
    plot_comparison(tps, mw)
