@extends('layouts.app')

@section('title', 'Hasil Kuesioner')

@section('content')
    <style>
        .container-custom {
            max-width: auto;
            margin: auto;
        }

        .card-custom {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .result-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            margin-bottom: 30px;
        }

        .score-display {
            font-size: 4rem;
            font-weight: bold;
            margin: 20px 0;
        }

        .category-badge {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .category-rendah {
            background: #28a745;
        }

        .category-sedang {
            background: #ffc107;
            color: #212529;
        }

        .category-tinggi {
            background: #dc3545;
        }

        .interpretation {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }

        .metrics-row {
            display: grid;
            grid-template-columns: repeat(2, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .metric-card {
            position: relative;
            background: linear-gradient(135deg, rgba(255,255,255,0.96) 0%, rgba(243,244,246,0.95) 100%);
            border: 1px solid rgba(102, 126, 234, 0.18);
            border-radius: 20px;
            padding: 24px 26px;
            text-align: left;
            box-shadow: 0 18px 40px rgba(102, 126, 234, 0.08);
            overflow: hidden;
        }

        .metric-card::after {
            content: "";
            position: absolute;
            right: -20px;
            top: -20px;
            width: 120px;
            height: 120px;
            background: rgba(102, 126, 234, 0.12);
            border-radius: 50%;
            pointer-events: none;
        }

        .metric-label {
            font-size: 0.82rem;
            font-weight: 700;
            color: #475569;
            margin-bottom: 10px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .metric-value {
            font-size: 2.3rem;
            font-weight: 800;
            color: #1f2937;
            line-height: 1.1;
            background: linear-gradient(90deg, #4f46e5 0%, #2563eb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .header-premium {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px;
            padding: 20px 24px 8px;
            border-radius: 28px;
            background: linear-gradient(180deg, rgba(99,102,241,0.08) 0%, rgba(243,244,246,0.7) 100%);
            border: 1px solid rgba(99,102,241,0.18);
            box-shadow: 0 16px 40px rgba(99,102,241,0.08);
        }

        .headline-title {
            margin: 0;
            font-size: 1.65rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
        }

        .headline-subtitle {
            margin: 0;
            font-size: 0.95rem;
            color: #475569;
            max-width: 680px;
            text-align: center;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .metrics-row {
                grid-template-columns: 1fr;
            }

            .header-premium {
                padding: 18px 18px 10px;
            }

            .headline-title {
                font-size: 1.4rem;
            }
        }

        .btn-custom {
            border-radius: 50px;
            padding: 10px 25px;
        }

        .method-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #e9ecef;
        }

        .method-tab {
            padding: 12px 20px;
            background: none;
            border: none;
            cursor: pointer;
            font-weight: 500;
            color: #666;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            transition: 0.3s;
        }

        .method-tab.active {
            color: #667eea;
            border-bottom-color: #667eea;
        }

        .method-content {
            display: none;
        }

        .method-content.active {
            display: block;
        }

        .comparison-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #f8f9fa;
        }

        .comparison-table th {
            background: #667eea;
            color: white;
            padding: 12px;
            text-align: left;
        }

        .comparison-table td {
            padding: 12px;
            border-bottom: 1px solid #dee2e6;
        }

        .comparison-table tr:hover {
            background: #e9ecef;
        }

        .chart-container {
            background: #ffffff;
            border-radius: 16px;
            padding: 20px;
            margin: 25px 0;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid #e7ebf0;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 14px;
            gap: 10px;
            flex-wrap: wrap;
        }

        .chart-header h5 {
            margin: 0;
            font-size: 1.05rem;
            color: #333;
            font-weight: 700;
        }

        .chart-wrapper {
            position: relative;
            height: 320px;
        }

        .comparison-image {
            display: block;
            width: 50%;
            max-width: 100%;
            border-radius: 16px;
            border: 1px solid #dee2e6;
        }

        /* Layout untuk hasil bersebelahan */
        .result-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            align-items: start;
            margin-bottom: 20px;
        }

        .result-card-compact {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            height: fit-content;
        }

        .score-display-compact {
            font-size: 3rem;
            font-weight: bold;
            margin: 15px 0;
        }

        .chart-container-compact {
            background: transparent;
            border-radius: 16px;
            padding: 0;
            box-shadow: none;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chart-header-compact {
            margin-bottom: 10px;
            display: none;
        }

        .chart-header-compact h5 {
            margin: 0;
            font-size: 1rem;
            color: #333;
            font-weight: 700;
        }

        .chart-wrapper-compact {
            position: relative;
            height: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            /* padding: 0 0; */
        }

        .comparison-image-compact {
            display: block;
            width: 100%;
            max-width: 100%;
            height: auto;
            border-radius: 16px;
            border: 1px solid #e7ebf0;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }

        /* Layout untuk grafik perbandingan yang lebih besar */
        .chart-container-large {
            background: transparent;
            border-radius: 20px;
            padding: 0;
            box-shadow: none;
            border: none;
            margin: 30px 0;
            display: flex;
            justify-content: center;
        }

        .chart-header-large {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 10px;
            flex-wrap: wrap;
        }

        .chart-header-large h5 {
            margin: 0;
            font-size: 1.2rem;
            color: #333;
            font-weight: 700;
        }

        .chart-wrapper-large {
            position: relative;
            max-width: 900px;
            width: 100%;
            height: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px 0;
        }

        .comparison-image-large {
            display: block;
            width: 100%;
            max-width: 100%;
            height: auto;
            border-radius: 20px;
            border: 1px solid #e7ebf0;
            box-shadow: 0 16px 30px rgba(0, 0, 0, 0.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .result-row {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .score-display-compact {
                font-size: 2.5rem;
            }

            .chart-wrapper-compact {
                height: 200px;
            }

            .chart-wrapper-large {
                height: 300px;
            }
        }

        /* Modern Comparison Styling */
        .comparison-chart-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            /* transition: transform 0.3s ease, box-shadow 0.3s ease; */
        }

        .comparison-chart-section:hover {
            /* transform: translateY(-2px); */
            /* box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12); */
        }

        .chart-header-elegant {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .chart-title-elegant {
            color: #2c3e50;
            font-weight: 700;
            font-size: 1.4rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .chart-icon {
            color: #3498db;
            font-size: 1.2rem;
        }

        .chart-badge .badge-modern {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        /* .chart-container-elegant {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.03);
        } */

        .comparison-image-elegant {
            display: block;
            width: 100%;
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            border: 2px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        /* .comparison-image-elegant:hover {
            transform: scale(1.02);
        } */

        /* Kesimpulan Perbandingan Card */
        .conclusion-card {
            background: linear-gradient(135deg, #f0f4ff 0%, #f9fafb 100%);
            border-radius: 20px;
            padding: 28px;
            margin-bottom: 30px;
            box-shadow: 0 12px 32px rgba(79, 70, 229, 0.08);
            border: 1px solid rgba(79, 70, 229, 0.15);
        }

        .conclusion-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
        }

        .conclusion-icon {
            font-size: 1.3rem;
            color: #4f46e5;
        }

        .conclusion-title {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 700;
            color: #1f2937;
        }

        .conclusion-content {
            color: #374151;
            line-height: 1.8;
            font-size: 0.95rem;
        }

        .conclusion-highlight {
            display: inline-block;
            padding: 8px 12px;
            background: rgba(79, 70, 229, 0.1);
            border-radius: 8px;
            font-weight: 600;
            color: #4f46e5;
            margin: 0 2px;
        }

        .comparison-values-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 24px;
            padding-bottom: 24px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        }

        .value-box {
            background: white;
            border-radius: 14px;
            padding: 18px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .value-box-label {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 8px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .value-box-number {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 4px;
            color: #1f2937;
        }

        .value-box-unit {
            font-size: 0.75rem;
            color: #999;
        }

        .method-arrow {
            font-size: 1.1rem;
            margin-left: 4px;
        }

        .arrow-up {
            color: #dc3545;
        }

        .arrow-down {
            color: #28a745;
        }

        /* Warna kategori */
        .category-badge-blue {
            background: #d1e7f7 !important;
            color: #0c5aa0 !important;
        }

        .category-badge-yellow {
            background: #fef3c7 !important;
            color: #92400e !important;
        }

        .category-badge-red {
            background: #fee2e2 !important;
            color: #7f1d1d !important;
        }

        .comparison-details-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .details-header {
            margin-bottom: 25px;
        }

        .details-title {
            color: #2c3e50;
            font-weight: 700;
            font-size: 1.3rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .details-icon {
            color: #e74c3c;
            font-size: 1.1rem;
        }

        .comparison-table-container {
            margin-bottom: 30px;
        }

        .comparison-table-modern {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .table-header-main {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 18px 20px;
            text-align: left;
            font-weight: 600;
            font-size: 1rem;
            border: none;
        }

        .table-header-method {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            padding: 18px 20px;
            text-align: center;
            font-weight: 600;
            font-size: 1rem;
            border: none;
        }

        .table-row-modern {
            transition: background-color 0.2s ease;
        }

        .table-row-modern:hover {
            background-color: #f8f9fa;
        }

        .table-row-alt {
            background-color: #f8f9fa;
        }

        .aspect-cell {
            padding: 16px 20px;
            font-weight: 600;
            color: #2c3e50;
            border-bottom: 1px solid #ecf0f1;
        }

        .value-cell {
            padding: 16px 20px;
            text-align: center;
            font-weight: 700;
            font-size: 1.1rem;
            color: #27ae60;
            border-bottom: 1px solid #ecf0f1;
            border-left: 1px solid #ecf0f1;
        }

        .category-cell {
            padding: 16px 20px;
            text-align: center;
            font-weight: 600;
            border-bottom: 1px solid #ecf0f1;
            border-left: 1px solid #ecf0f1;
        }

        .difference-cell {
            padding: 16px 20px;
            text-align: center;
            font-weight: 700;
            font-size: 1.1rem;
            color: #e74c3c;
            border-bottom: 1px solid #ecf0f1;
        }

        .method-explanation-modern {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .explanation-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .explanation-icon {
            color: #f39c12;
            font-size: 1.1rem;
        }

        .explanation-title {
            font-weight: 700;
            color: #2c3e50;
            font-size: 1.1rem;
            margin: 0;
        }

        .method-item-modern {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid;
        }

        .method-item-modern:nth-child(1) {
            border-left-color: #3498db;
        }

        .method-item-modern:nth-child(2) {
            border-left-color: #e74c3c;
        }

        .method-label {
            font-weight: 700;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 120px;
        }

        .tsukamoto-label {
            color: #3498db;
        }

        .mamdani-label {
            color: #e74c3c;
        }

        .method-desc {
            color: #7f8c8d;
            line-height: 1.5;
            flex: 1;
        }

        .method-note {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-radius: 10px;
            border: 1px solid #c3e6cb;
            color: #155724;
            font-weight: 500;
        }

        .note-icon {
            color: #28a745;
            font-size: 1rem;
        }

        /* Elegant Result Card Styling */
        .result-card-elegant {
            background: #F9B2D7;
            color: white;
            border-radius: 20px;
            padding: 10px;
            text-align: center;
            height: fit-content;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .result-card-elegant:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .method-header-elegant {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }

        .method-title-elegant {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .method-icon-tsukamoto {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .method-icon-mamdani {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .score-display-elegant {
            font-size: 3.5rem;
            font-weight: 800;
            margin: 10px 0;
            letter-spacing: -1px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .category-badge-elegant {
            display: inline-block;
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: 700;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 15px;
        }

        .category-badge-elegant span {
            color: white;
        }

        .interpretation-elegant {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 18px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .chart-container-elegant {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chart-wrapper-elegant {
            /* position: relative;
            width: 100%;
            height: auto; */
            display: flex;
            justify-content: center;
            align-items: center;
        }

.chart-image-elegant {
    max-height: 350px;
    width: auto;
    max-width: 100%;
    object-fit: contain;
}

        .chart-image-elegant:hover {
            transform: scale(1.02);
            filter: brightness(1.05);
        }

        /* Responsive untuk comparison dan method cards */
        @media (max-width: 768px) {
            .comparison-chart-section,
            .comparison-details-section {
                padding: 20px;
                margin-bottom: 20px;
            }

            .conclusion-card {
                padding: 20px;
                margin-bottom: 24px;
            }

            .comparison-values-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .chart-header-elegant {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .chart-title-elegant {
                font-size: 1.2rem;
            }

            .details-title {
                font-size: 1.1rem;
            }

            .comparison-table-modern {
                font-size: 0.9rem;
            }

            .table-header-main,
            .table-header-method {
                padding: 12px 15px;
                font-size: 0.9rem;
            }

            .aspect-cell,
            .value-cell,
            .category-cell,
            .difference-cell {
                padding: 12px 15px;
            }

            .method-item-modern {
                flex-direction: column;
                gap: 10px;
            }

            .method-label {
                min-width: auto;
            }

            .result-row {
                grid-template-columns: 1fr;
            }

            .result-card-elegant {
                padding: 20px;
                margin-bottom: 15px;
            }

            .score-display-elegant {
                font-size: 2.8rem;
            }

            .chart-container-elegant {
                padding: 15px;
            }
        }

        .simple-result-card {
    background: linear-gradient(135deg, #eaf7fb 0%, #ffffff 100%);
    border-radius: 22px;
    padding: 32px;
    border: 1px solid #dceef5;
    box-shadow: 0 10px 28px rgba(0, 0, 0, 0.06);
}

.score-circle {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: #0d6efd;
    color: white;
    margin: auto;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    font-weight: 800;
    box-shadow: 0 10px 25px rgba(13, 110, 253, 0.25);
}

.info-box {
    background: #ffffff;
    border-radius: 18px;
    padding: 24px;
    border: 1px solid #e9ecef;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
}

.calculation-step {
    background: #f8f9fa;
    border-radius: 14px;
    padding: 14px 16px;
    margin-bottom: 12px;
    border-left: 4px solid #0d6efd;
}

.calculation-step strong {
    display: block;
    color: #212529;
    margin-bottom: 4px;
}

.calculation-step span {
    color: #6c757d;
    font-size: 0.9rem;
}

.recommendation-card {
    background: #f8f9fa;
    border-radius: 16px;
    padding: 18px;
    height: 100%;
    border: 1px solid #e9ecef;
}

.recommendation-card h6 {
    font-weight: 700;
    margin-bottom: 8px;
}

.recommendation-card p {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 0;
    line-height: 1.6;
}

.info-box hr {
    border-top: 1px solid #e5e7eb;
    opacity: 1;
}

.info-box ul li {
    margin-bottom: 6px;
}

.comparison-values-grid{
    display:flex;
    flex-direction:column;
    gap:16px;
    height:100%;
}

.value-box{
    flex:1;
    min-height:130px;
}

.comparison-chart-section{
    height:100%;
}

.comparison-image-elegant{
    width:100%;
    max-height:380px;
    object-fit:contain;
}
    </style>

    <div class="container container-custom py-3 mb-3">
        <div class="card-custom">
            <div class="header-premium">
                <h3 class="headline-title">Hasil Analisis Tingkat Stres Mahasiswa Dalam Penyusunan Skripsi</h3>
                <p class="headline-subtitle">Ringkasan dua indikator utama: Tekanan Penyusunan Skripsi (TPS) dan Manajemen Waktu (MW). Lihat skor input Anda dan bandingkan hasil perhitungan antara metode Tsukamoto dan Mamdani.</p>
            </div>

            <!-- Data Input -->
            <div class="metrics-row">
                <div class="metric-card">
                    <div class="metric-label">Tekanan Penyusunan Skripsi (TPS)</div>
                    <div class="metric-value" id="tps-value">-</div>
                </div>
                <div class="metric-card">
                    <div class="metric-label">Manajemen Waktu (MW)</div>
                    <div class="metric-value" id="mw-value">-</div>
                </div>
            </div>

            <!-- Method Tabs -->
            <div class="method-tabs">
                <button class="method-tab active" onclick="switchMethod(event, 'tsukamoto')">
                    Metode Tsukamoto
                </button>
                <button class="method-tab" onclick="switchMethod(event, 'mamdani')">
                    Metode Mamdani
                </button>
                <button class="method-tab" onclick="switchMethod(event, 'comparison')">
                    Perbandingan
                </button>
            </div>

            <!-- Tsukamoto Result -->
<div id="tsukamoto" class="method-content active">

    <!-- HASIL + GRAFIK -->
    <div class="row g-4 mb-4">

        <div class="col-lg-5">
            <div class="simple-result-card h-100">

                <p class="text-muted mb-1">Hasil Metode Tsukamoto</p>
                <h3 class="fw-bold mb-4">Tingkat Stres Anda</h3>

                <div class="text-center">
                    <div class="score-circle">
                        <span id="skor-tsukamoto">-</span>
                    </div>

                    <div class="mt-3">
                        <span class="badge fs-6 px-4 py-2" id="category-badge-tsukamoto">
                            <span id="kategori-tsukamoto">-</span>
                        </span>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-lg-7">
            <div class="info-box h-100">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-graph-up text-primary me-2"></i>
                    Visualisasi Hasil
                </h5>

                <div class="chart-wrapper-elegant">
                    <img id="tsukamoto-img"
                        class="chart-image-elegant"
                        src=""
                        alt="Grafik Tsukamoto Python" />
                </div>
            </div>
        </div>

    </div>

    <!-- INTERPRETASI + PERHITUNGAN -->
    <div class="row g-4">

        <div class="col-lg-6">
            <div class="info-box h-100">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-info-circle text-primary me-2"></i>
                    Apa Maksud Hasil Ini?
                </h5>

                <p id="interpretation-text-tsukamoto"
                    class="text-muted mb-0"
                    style="line-height: 1.8;">
                    Memuat interpretasi hasil...
                </p>
                <hr class="my-3">

        <h6 class="fw-bold mb-3">
            <i class="bi bi-lightbulb text-warning me-2"></i>
            Saran Selanjutnya
        </h6>

        <ul class="text-muted mb-0 ps-3" style="line-height: 1.4;">
            <li>Buat target skripsi mingguan yang realistis.</li>
            <li>Fokus mengerjakan satu tugas terlebih dahulu.</li>
            <li>Luangkan waktu istirahat secara teratur.</li>
            <li>Diskusikan kendala dengan dosen pembimbing.</li>
        </ul>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="info-box h-100">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-calculator text-primary me-2"></i>
                    Ringkasan Perhitungan
                </h5>

                <div class="calculation-step">
                    <strong>1. Fuzzifikasi</strong>
                    <span>TPS dan MW diubah menjadi nilai fuzzy.</span>
                </div>

                <div class="calculation-step">
                    <strong>2. Inferensi</strong>
                    <span>Aturan fuzzy diproses sesuai kondisi Anda.</span>
                </div>

                <div class="calculation-step">
                    <strong>3. Defuzzifikasi</strong>
                    <span>Hasil akhir dihitung menjadi satu nilai stres.</span>
                </div>
            </div>
        </div>

    </div>

    <!-- REKOMENDASI -->
    <div class="info-box mt-4">
        <h5 class="fw-bold mb-3">
            <i class="bi bi-heart-pulse text-danger me-2"></i>
            Rekomendasi
        </h5>

        <div id="recommendation-tsukamoto" class="row g-3">
        </div>

    </div>

</div>

            <!-- Mamdani Result -->
            <div id="mamdani" class="method-content">

    <!-- HASIL + GRAFIK -->
    <div class="row g-4 mb-4">

        <div class="col-lg-5">
            <div class="simple-result-card h-100">

                <p class="text-muted mb-1">Hasil Metode Mamdani</p>
                <h3 class="fw-bold mb-4">Tingkat Stres Anda</h3>

                <div class="text-center">
                    <div class="score-circle">
                        <span id="skor-mamdani">-</span>
                    </div>

                    <div class="mt-3">
                        <span class="badge fs-6 px-4 py-2" id="category-badge-mamdani">
                            <span id="kategori-mamdani">-</span>
                        </span>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-lg-7">
            <div class="info-box h-100">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-graph-up text-primary me-2"></i>
                    Visualisasi Hasil
                </h5>

                <div class="chart-wrapper-elegant">
                    <img id="mamdani-img"
                        class="chart-image-elegant"
                        src=""
                        alt="Grafik Mamdani Python" />
                </div>
            </div>
        </div>

    </div>

    <!-- INTERPRETASI + PERHITUNGAN -->
    <div class="row g-4">

        <div class="col-lg-6">
            <div class="info-box h-100">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-info-circle text-primary me-2"></i>
                    Apa Maksud Hasil Ini?
                </h5>

                <p id="interpretation-text-mamdani"
                    class="text-muted mb-0"
                    style="line-height: 1.8;">
                    Memuat interpretasi hasil...
                </p>
                <hr class="my-3">

<h6 class="fw-bold mb-3">
    <i class="bi bi-stars text-warning me-2"></i>
    Hal yang Perlu Diperhatikan
</h6>

<div class="text-muted" style="line-height:1.8;">
    Hasil metode Mamdani mempertimbangkan keseluruhan area fuzzy sehingga
    lebih sensitif terhadap perubahan nilai TPS dan MW. Oleh karena itu,
    perubahan kecil pada pola pengerjaan skripsi maupun manajemen waktu
    dapat memengaruhi tingkat stres yang dihasilkan.
</div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="info-box h-100">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-calculator text-primary me-2"></i>
                    Ringkasan Perhitungan
                </h5>

                <div class="calculation-step">
                    <strong>1. Fuzzifikasi</strong>
                    <span>TPS dan MW diubah menjadi derajat keanggotaan fuzzy.</span>
                </div>

                <div class="calculation-step">
                    <strong>2. Inferensi</strong>
                    <span>Aturan fuzzy digabungkan untuk membentuk area output.</span>
                </div>

                <div class="calculation-step">
                    <strong>3. Defuzzifikasi Centroid</strong>
                    <span>Nilai akhir diambil dari titik pusat area hasil fuzzy.</span>
                </div>
            </div>
        </div>

    </div>

    <!-- REKOMENDASI -->
    <div class="info-box mt-4">
        <h5 class="fw-bold mb-3">
            <i class="bi bi-heart-pulse text-danger me-2"></i>
            Rekomendasi
        </h5>

        <div id="recommendation-mamdani" class="row g-3">
        </div>
    </div>

</div>

            <!-- Comparison Result -->
            <div id="comparison" class="method-content">
                <!-- Kesimpulan Perbandingan -->
<div class="conclusion-card">
    <div class="conclusion-header">
        <i class="fas fa-clipboard-check conclusion-icon"></i>
        <h4 class="conclusion-title">Ringkasan Hasil Anda</h4>
    </div>

    <div class="conclusion-content" id="conclusion-text">
        Memproses ringkasan hasil...
    </div>
</div>

                <!-- Nilai Perbandingan Highlighted -->
                <div class="row g-4 align-items-stretch">

    <!-- GRAFIK -->
    <div class="col-lg-8">
        <div class="comparison-chart-section h-100">

            <div class="chart-header-elegant">
                <h5 class="chart-title-elegant">
                    <i class="fas fa-chart-line chart-icon"></i>
                    Grafik Perbandingan Output Metode
                </h5>
            </div>

            <div class="chart-container-elegant">
                <img id="comparison-img"
                    class="comparison-image-elegant"
                    src=""
                    alt="Grafik perbandingan" />
            </div>

            <p class="small text-muted text-center mt-3 mb-0">
                Perbandingan hasil defuzzifikasi metode Tsukamoto dan Mamdani.
            </p>

        </div>
    </div>

    <!-- VALUE BOX -->
    <div class="col-lg-4">

        <div class="comparison-values-grid">

            <div class="value-box">
                <div class="value-box-label"><i class="bi bi-graph-up-arrow"></i> Tsukamoto</div>
                <div class="value-box-number" id="highlight-tsukamoto">-</div>
                <div class="value-box-unit" id="highlight-kat-tsukamoto">-</div>
            </div>

            <div class="value-box">
                <div class="value-box-label"><i class="bi bi-diagram-3"></i> Selisih</div>
                <div class="value-box-number" id="highlight-selisih">-</div>
                <div class="value-box-unit">Perbedaan Nilai</div>
            </div>

            <div class="value-box">
                <div class="value-box-label"><i class="bi bi-arrow-left-right"></i> Mamdani</div>
                <div class="value-box-number" id="highlight-mamdani">-</div>
                <div class="value-box-unit" id="highlight-kat-mamdani">-</div>
            </div>

        </div>

    </div>

</div>

                <!-- Detail Perbandingan -->
                <div class="comparison-details-section">
                    {{-- <div class="details-header">
                        <h5 class="details-title">
                            <i class="fas fa-balance-scale details-icon"></i>
                            Analisis Perbandingan Output
                        </h5>
                    </div>

                    <div class="comparison-table-container">
                        <table class="comparison-table-modern">
                            <thead>
                                <tr>
                                    <th class="table-header-main">
                                        <i class="fas fa-list-ul"></i> Aspek
                                    </th>
                                    <th class="table-header-method">
                                        <i class="fas fa-calculator"></i> Tsukamoto
                                    </th>
                                    <th class="table-header-method">
                                        <i class="fas fa-brain"></i> Mamdani
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="table-row-modern">
                                    <td class="aspect-cell">
                                        <strong>Skor Akhir</strong>
                                    </td>
                                    <td class="value-cell" id="comp-skor-tsukamoto">-</td>
                                    <td class="value-cell" id="comp-skor-mamdani">-</td>
                                </tr>
                                <tr class="table-row-modern table-row-alt">
                                    <td class="aspect-cell">
                                        <strong>Kategori</strong>
                                    </td>
                                    <td class="category-cell" id="comp-kat-tsukamoto">-</td>
                                    <td class="category-cell" id="comp-kat-mamdani">-</td>
                                </tr>
                                <tr class="table-row-modern">
                                    <td class="aspect-cell">
                                        <strong>Selisih Nilai</strong>
                                    </td>
                                    <td colspan="2" class="difference-cell" id="comp-selisih">-</td>
                                </tr>
                                <tr class="table-row-modern table-row-alt">
                                    <td class="aspect-cell" style="color: #4f46e5; font-weight: 700;">
                                        <i class="fas fa-info-circle" style="margin-right: 6px;"></i>Interpretasi
                                    </td>
                                    <td colspan="2" style="padding: 14px 20px; font-size: 0.9rem; color: #374151; border-bottom: 1px solid #ecf0f1;">
                                        <span id="comp-interpretasi">-</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div> --}}

                    <div class="method-explanation-modern">
                        <div class="explanation-header">
                            <i class="fas fa-info-circle explanation-icon"></i>
                            <span class="explanation-title">Mengapa Hasilnya Bisa Berbeda?</span>
                        </div>
                        <div class="explanation-content">
                            <div class="method-item-modern">
                                <div class="method-label tsukamoto-label">
                                    <i class="fas fa-calculator"></i>
                                    <strong>Metode Tsukamoto</strong>
                                </div>
                                <div class="method-desc">
                                    Menghasilkan output crisp pada setiap rule dengan memanfaatkan single point (singleton) pada fungsi keanggotaan output dan menghitung nilai akhir menggunakan metode weighted average (rata-rata tertimbang).
                                </div>
                            </div>
                            <div class="method-item-modern">
                                <div class="method-label mamdani-label">
                                    <i class="fas fa-brain"></i>
                                    <strong>Metode Mamdani</strong>
                                </div>
                                <div class="method-desc">
                                    Menggunakan fungsi keanggotaan output yang didefinisikan sebagai trapesium atau segitiga, kemudian menghitung nilai akhir menggunakan metode centroid (center of gravity) berdasarkan luas area di bawah kurva keanggotaan.
                                </div>
                            </div>
                            <div class="method-note">
                                <i class="fas fa-check-circle note-icon"></i>
                                Kedua metode menggunakan data dan aturan fuzzy yang sama. Perbedaan hasil muncul karena cara menghitung nilai akhirnya berbeda.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button onclick="window.location.href='/kuesioner'" class="btn btn-primary btn-custom me-2">
                    Isi Kuesioner Lagi
                </button>
                <button onclick="window.location.href='/'" class="btn btn-secondary btn-custom">
                    Kembali ke Beranda
                </button>
            </div>
        </div>
    </div>

    <script>
        function switchMethod(event, method) {
            // Sembunyikan semua content
            document.querySelectorAll('.method-content').forEach(el => {
                el.classList.remove('active');
            });

            // Hilangkan active dari semua tab
            document.querySelectorAll('.method-tab').forEach(el => {
                el.classList.remove('active');
            });

            // Tampilkan content yang dipilih
            document.getElementById(method).classList.add('active');

            // Tandai tab yang aktif
            event.currentTarget.classList.add('active');
        }

        function renderTsukamotoImage(tps, mw) {
            const image = document.getElementById('tsukamoto-img');
            image.src = `/hasil/tsukamoto-image?tps=${encodeURIComponent(tps)}&mw=${encodeURIComponent(mw)}`;
        }

        function renderMamdaniImage(tps, mw) {
            const image = document.getElementById('mamdani-img');
            image.src = `/hasil/mamdani-image?tps=${encodeURIComponent(tps)}&mw=${encodeURIComponent(mw)}`;
        }

        function renderComparisonImage(tps, mw) {
            const image = document.getElementById('comparison-img');
            image.src = `/hasil/comparison-image?tps=${encodeURIComponent(tps)}&mw=${encodeURIComponent(mw)}`;
        }

function getInterpretationText(kategori, nilai, method) {
    if (kategori === "Rendah") {
        return `
            Nilai akhir Anda adalah <strong>${nilai}</strong> dan termasuk kategori
            <strong>Stres Rendah</strong>. Artinya, tekanan yang dirasakan masih tergolong ringan
            dan Anda cenderung mampu mengelola proses penyusunan skripsi dengan baik.
        `;
    } else if (kategori === "Sedang") {
        return `
            Nilai akhir Anda adalah <strong>${nilai}</strong> dan termasuk kategori
            <strong>Stres Sedang</strong>. Artinya, Anda mulai merasakan tekanan dalam penyusunan skripsi,
            tetapi kondisi ini masih dapat dikendalikan dengan pengaturan waktu, istirahat cukup,
            dan dukungan dari lingkungan sekitar.
        `;
    } else {
        return `
            Nilai akhir Anda adalah <strong>${nilai}</strong> dan termasuk kategori
            <strong>Stres Tinggi</strong>. Artinya, tekanan yang dirasakan cukup besar.
            Disarankan untuk tidak memendam beban sendiri dan mulai mencari dukungan dari dosen pembimbing,
            teman, keluarga, atau konselor kampus.
        `;
    }
}

function getRecommendationTsukamoto(kategori) {
    if (kategori === "Rendah") {
        return `
            <div class="col-md-4">
                <div class="recommendation-card">
                    <h6>🎧 Dengarkan Musik Santai</h6>
                    <p>Dengarkan playlist lofi, instrumental, atau musik akustik agar suasana belajar tetap nyaman.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="recommendation-card">
                    <h6>📅 Pertahankan Jadwal</h6>
                    <p>Buat jadwal skripsi ringan agar progres tetap berjalan tanpa menumpuk pekerjaan.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="recommendation-card">
                    <h6>🚶 Healing Ringan</h6>
                    <p>Luangkan waktu berjalan santai, jajan, atau keluar sebentar agar pikiran tetap segar.</p>
                </div>
            </div>
        `;
    } else if (kategori === "Sedang") {
        return `
            <div class="col-md-4">
                <div class="recommendation-card">
                    <h6>▶️ Konten YouTube Relaksasi</h6>
                    <p>Tonton konten study with me, meditasi singkat, atau musik lofi untuk membantu fokus.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="recommendation-card">
                    <h6>⏰ Teknik Pomodoro</h6>
                    <p>Kerjakan skripsi 25 menit, lalu istirahat 5 menit agar tidak cepat lelah.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="recommendation-card">
                    <h6>☕ Istirahat Terarah</h6>
                    <p>Coba healing sederhana seperti ngopi, jalan sore, atau ngobrol dengan teman dekat.</p>
                </div>
            </div>
        `;
    } else {
        return `
            <div class="col-md-4">
                <div class="recommendation-card">
                    <h6>🧘 Latihan Napas</h6>
                    <p>Coba teknik napas 4-7-8 atau meditasi singkat selama 5–10 menit untuk menenangkan diri.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="recommendation-card">
                    <h6>👥 Cari Dukungan</h6>
                    <p>Ceritakan kondisi Anda kepada teman, keluarga, dosen pembimbing, atau konselor kampus.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="recommendation-card">
                    <h6>🌿 Healing Sejenak</h6>
                    <p>Ambil jeda dari skripsi, pergi ke tempat tenang, tidur cukup, dan kurangi memaksakan diri.</p>
                </div>
            </div>
        `;
    }
}

function getRecommendationMamdani(kategori) {
    if (kategori === "Rendah") {
        return `
            <div class="col-md-4">
                <div class="recommendation-card">
                    <h6>🎧 Musik Santai</h6>
                    <p>Dengarkan musik lofi atau instrumental agar suasana tetap tenang.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="recommendation-card">
                    <h6>📅 Jaga Rutinitas</h6>
                    <p>Tetap buat jadwal skripsi ringan supaya progres tetap stabil.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="recommendation-card">
                    <h6>🚶 Healing Ringan</h6>
                    <p>Jalan santai, jajan sebentar, atau ngobrol ringan agar pikiran tetap fresh.</p>
                </div>
            </div>
        `;
    } else if (kategori === "Sedang") {
        return `
            <div class="col-md-4">
                <div class="recommendation-card">
                    <h6>▶️ YouTube Relaksasi</h6>
                    <p>Tonton konten study with me, lofi, atau meditasi singkat.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="recommendation-card">
                    <h6>⏰ Pomodoro</h6>
                    <p>Kerjakan skripsi 25 menit, lalu istirahat 5 menit agar tidak cepat jenuh.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="recommendation-card">
                    <h6>☕ Istirahat Terarah</h6>
                    <p>Ambil jeda sebentar seperti ngopi, jalan sore, atau ngobrol dengan teman.</p>
                </div>
            </div>
        `;
    } else {
        return `
            <div class="col-md-4">
                <div class="recommendation-card">
                    <h6>🧘 Tenangkan Diri</h6>
                    <p>Coba napas perlahan, meditasi singkat, atau dengarkan audio relaksasi.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="recommendation-card">
                    <h6>👥 Cari Dukungan</h6>
                    <p>Ceritakan kondisi ke teman, keluarga, dosen pembimbing, atau konselor kampus.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="recommendation-card">
                    <h6>🌿 Healing Sejenak</h6>
                    <p>Berhenti sebentar dari skripsi, tidur cukup, dan hindari memaksakan diri.</p>
                </div>
            </div>
        `;
    }
}

        function getCategoryColor(kategori) {
            if (kategori.toLowerCase() === "rendah") return "category-badge-blue";
            if (kategori.toLowerCase() === "sedang") return "category-badge-yellow";
            if (kategori.toLowerCase() === "tinggi") return "category-badge-red";
            return "";
        }

function generateConclusion(tsukamoto, mamdani) {
    const selisih = Math.abs(
        tsukamoto.nilai - mamdani.nilai
    ).toFixed(2);

    if (tsukamoto.kategori === mamdani.kategori) {
        return `
            Hasil analisis menunjukkan bahwa metode Tsukamoto menghasilkan nilai
            <strong>${tsukamoto.nilai}</strong> dan metode Mamdani menghasilkan nilai
            <strong>${mamdani.nilai}</strong>. Meskipun terdapat selisih nilai sebesar
            <strong>${selisih}</strong>, kedua metode memberikan kategori yang sama yaitu
            <strong>${tsukamoto.kategori}</strong>.

            Hal ini menunjukkan bahwa kedua metode memiliki interpretasi yang sejalan terhadap
            kondisi yang dialami. Dengan kata lain, perbedaan nilai yang dihasilkan tidak
            memengaruhi kesimpulan akhir mengenai tingkat stres yang diperoleh.
        `;
    }

    return `
        Hasil analisis menunjukkan bahwa metode Tsukamoto menghasilkan nilai
        <strong>${tsukamoto.nilai}</strong> dengan kategori
        <strong>${tsukamoto.kategori}</strong>, sedangkan metode Mamdani menghasilkan nilai
        <strong>${mamdani.nilai}</strong> dengan kategori
        <strong>${mamdani.kategori}</strong>.

        Perbedaan nilai sebesar <strong>${selisih}</strong> menunjukkan bahwa kedua metode
        memberikan interpretasi yang berbeda terhadap data yang sama. Pada kasus ini,
        metode Mamdani menghasilkan tingkat stres yang lebih tinggi dibandingkan metode
        Tsukamoto. Perbedaan tersebut terjadi karena kedua metode menggunakan pendekatan
        defuzzifikasi yang berbeda dalam menentukan nilai akhir hasil analisis.
    `;
}

        // ===========================
        // Main Execution
        // ===========================

        const data = JSON.parse(sessionStorage.getItem("hasil"));

        if (data && data.tps !== undefined && data.mw !== undefined) {
            // Tampilkan input metrics
            document.getElementById("tps-value").innerText = data.tps.toFixed(2);
            document.getElementById("mw-value").innerText = data.mw.toFixed(2);

            // Fetch hasil perhitungan dari Python
            fetch(`/hasil/calculate?tps=${encodeURIComponent(data.tps)}&mw=${encodeURIComponent(data.mw)}`)
                .then(response => response.json())
                .then(result => {
                    if (result.error) {
                        alert('Error: ' + result.error);
                        return;
                    }

                    const hasilTsukamoto = result.tsukamoto;
                    const hasilMamdani = result.mamdani;
                    const selisihNilai = Math.abs(hasilTsukamoto.nilai - hasilMamdani.nilai).toFixed(2);

                    // ===== TAMPILKAN TSUKAMOTO =====
                    document.getElementById("skor-tsukamoto").innerText = hasilTsukamoto.nilai;
                    document.getElementById("kategori-tsukamoto").innerText = hasilTsukamoto.kategori;

                    const badge_tsukamoto = document.getElementById("category-badge-tsukamoto");
                    badge_tsukamoto.className = 'category-badge category-' + hasilTsukamoto.kategori.toLowerCase();

                    const interpretation_tsukamoto = document.getElementById("interpretation-text-tsukamoto");
                    interpretation_tsukamoto.innerHTML = getInterpretationText(hasilTsukamoto.kategori, hasilTsukamoto.nilai, 'Tsukamoto');
                    document.getElementById("recommendation-tsukamoto").innerHTML =
    getRecommendationTsukamoto(hasilTsukamoto.kategori);

                    // ===== TAMPILKAN MAMDANI =====
                    document.getElementById("skor-mamdani").innerText = hasilMamdani.nilai;
                    document.getElementById("kategori-mamdani").innerText = hasilMamdani.kategori;

                    const badge_mamdani = document.getElementById("category-badge-mamdani");
                    badge_mamdani.className = 'category-badge category-' + hasilMamdani.kategori.toLowerCase();

                    const interpretation_mamdani = document.getElementById("interpretation-text-mamdani");
                    interpretation_mamdani.innerHTML = getInterpretationText(hasilMamdani.kategori, hasilMamdani.nilai, 'Mamdani');
                    document.getElementById("recommendation-mamdani").innerHTML =
    getRecommendationMamdani(hasilMamdani.kategori);

                    // Render gambar dari Python
                    renderTsukamotoImage(data.tps, data.mw);
                    renderMamdaniImage(data.tps, data.mw);
                    renderComparisonImage(data.tps, data.mw);

                    // ===== TAMPILKAN PERBANDINGAN =====
                    // document.getElementById("comp-skor-tsukamoto").innerText = hasilTsukamoto.nilai;
                    // document.getElementById("comp-skor-mamdani").innerText = hasilMamdani.nilai;

                    // document.getElementById("comp-kat-tsukamoto").innerText = hasilTsukamoto.kategori;
                    // document.getElementById("comp-kat-tsukamoto").className = "category-cell " + getCategoryColor(hasilTsukamoto.kategori);

                    // document.getElementById("comp-kat-mamdani").innerText = hasilMamdani.kategori;
                    // document.getElementById("comp-kat-mamdani").className = "category-cell " + getCategoryColor(hasilMamdani.kategori);

                    // document.getElementById("comp-selisih").innerText = selisihNilai;

                    // ===== HIGHLIGHTED VALUES BOX =====
                    document.getElementById("highlight-tsukamoto").innerText = hasilTsukamoto.nilai;
                    document.getElementById("highlight-kat-tsukamoto").innerText = hasilTsukamoto.kategori;

                    document.getElementById("highlight-mamdani").innerText = hasilMamdani.nilai;
                    document.getElementById("highlight-kat-mamdani").innerText = hasilMamdani.kategori;

                    document.getElementById("highlight-selisih").innerText = selisihNilai;

                    // ===== KESIMPULAN PERBANDINGAN =====
                    const conclusionText = generateConclusion(hasilTsukamoto, hasilMamdani);
                    document.getElementById("conclusion-text").innerHTML = conclusionText;

                    // ===== INTERPRETASI DINAMIS DI TABEL =====
                    // let interpretasiTabel = "";
                    // if (hasilTsukamoto.kategori === hasilMamdani.kategori) {
                    //     interpretasiTabel = `Kedua metode mengklasifikasikan tingkat stres ke dalam kategori <strong>${hasilTsukamoto.kategori}</strong> dengan perbedaan nilai <strong>${selisihNilai}</strong>.`;
                    // } else {
                    //     interpretasiTabel = `Terjadi perbedaan kategori: Tsukamoto → <strong>${hasilTsukamoto.kategori}</strong>, Mamdani → <strong>${hasilMamdani.kategori}</strong>. Perbedaan nilai sebesar <strong>${selisihNilai}</strong> tercermin dalam perbedaan klasifikasi.`;
                    // }
                    // document.getElementById("comp-interpretasi").innerHTML = interpretasiTabel;

                })
                .catch(error => {
                    console.error('Error fetching calculation results:', error);
                    alert('Terjadi kesalahan saat menghitung hasil. Silakan coba lagi.');
                });

        } else {
            alert("Data hasil tidak ditemukan. Silakan isi kuesioner terlebih dahulu.");
            window.location.href = "/kuesioner";
        }
    </script>
@endsection
