<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <div>
                            <p class="text-muted fw-medium mt-1 mb-2">{{ __('Users') }}</p>
                            <h4>{{ $users }}</h4>
                        </div>
                    </div>

                    <div class="col-4">
                        <div style="position: relative;">
                            <div id="radial-chart-1" style="min-height: 86.7px;">
                                <div id="apexchartsz1htoduf"
                                    class="apexcharts-canvas apexchartsz1htoduf apexcharts-theme-light"
                                    style="width: 58.0875px; height: 86.7px;"><svg id="SvgjsSvg1427" width="58.0875"
                                        height="86.7" xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs"
                                        class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)"
                                        style="background: transparent;">
                                        <g id="SvgjsG1429" class="apexcharts-inner apexcharts-graphical"
                                            transform="translate(-17.95625, -12)">
                                            <defs id="SvgjsDefs1428">
                                                <clipPath id="gridRectMaskz1htoduf">
                                                    <rect id="SvgjsRect1431" width="102" height="120"
                                                        x="-3" y="-1" rx="0" ry="0"
                                                        opacity="1" stroke-width="0" stroke="none"
                                                        stroke-dasharray="0" fill="#fff"></rect>
                                                </clipPath>
                                                <clipPath id="gridRectMarkerMaskz1htoduf">
                                                    <rect id="SvgjsRect1432" width="100" height="122"
                                                        x="-2" y="-2" rx="0" ry="0"
                                                        opacity="1" stroke-width="0" stroke="none"
                                                        stroke-dasharray="0" fill="#fff"></rect>
                                                </clipPath>
                                            </defs>
                                            <g id="SvgjsG1433" class="apexcharts-radialbar">
                                                <g id="SvgjsG1434">
                                                    <g id="SvgjsG1435" class="apexcharts-tracks">
                                                        <g id="SvgjsG1436"
                                                            class="apexcharts-radialbar-track apexcharts-track"
                                                            rel="1">
                                                            <path id="apexcharts-radialbarTrack-0"
                                                                d="M 48 16.919512195121953 A 31.080487804878047 31.080487804878047 0 1 1 47.994575431574326 16.91951266850485"
                                                                fill="none" fill-opacity="1"
                                                                stroke="rgba(242,242,242,0.85)" stroke-opacity="1"
                                                                stroke-linecap="butt" stroke-width="3.07087804878049"
                                                                stroke-dasharray="0" class="apexcharts-radialbar-area"
                                                                data:pathOrig="M 48 16.919512195121953 A 31.080487804878047 31.080487804878047 0 1 1 47.994575431574326 16.91951266850485">
                                                            </path>
                                                        </g>
                                                    </g>
                                                    <g id="SvgjsG1438">
                                                        <g id="SvgjsG1442"
                                                            class="apexcharts-series apexcharts-radial-series"
                                                            seriesName="seriesx1" rel="1" data:realIndex="0">
                                                            <path id="SvgjsPath1443"
                                                                d="M 48 16.919512195121953 A 31.080487804878047 31.080487804878047 0 1 1 18.44069954353868 57.60439892517063"
                                                                fill="none" fill-opacity="0.85"
                                                                stroke="rgba(59,93,231,0.85)" stroke-opacity="1"
                                                                stroke-linecap="butt" stroke-width="3.1658536585365873"
                                                                stroke-dasharray="0"
                                                                class="apexcharts-radialbar-area apexcharts-radialbar-slice-0"
                                                                data:angle="252" data:value="70" index="0"
                                                                j="0"
                                                                data:pathOrig="M 48 16.919512195121953 A 31.080487804878047 31.080487804878047 0 1 1 18.44069954353868 57.60439892517063">
                                                            </path>
                                                        </g>
                                                        <circle id="SvgjsCircle1439" r="24.5450487804878" cx="48"
                                                            cy="48" class="apexcharts-radialbar-hollow"
                                                            fill="rgba(59, 93, 231, .25)"></circle>
                                                        <g id="SvgjsG1440" class="apexcharts-datalabels-group"
                                                            transform="translate(0, 0) scale(1)" style="opacity: 1;">
                                                            <text id="SvgjsText1441"
                                                                font-family="Helvetica, Arial, sans-serif"
                                                                x="48" y="53" text-anchor="middle"
                                                                dominant-baseline="auto" font-size="12px"
                                                                font-weight="400" fill="#373d3f"
                                                                class="apexcharts-text apexcharts-datalabel-value"
                                                                style="font-family: Helvetica, Arial, sans-serif;">{{ $users }}</text>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                            <line id="SvgjsLine1444" x1="0" y1="0" x2="96"
                                                y2="0" stroke="#b6b6b6" stroke-dasharray="0"
                                                stroke-width="1" class="apexcharts-ycrosshairs"></line>
                                            <line id="SvgjsLine1445" x1="0" y1="0" x2="96"
                                                y2="0" stroke-dasharray="0" stroke-width="0"
                                                class="apexcharts-ycrosshairs-hidden"></line>
                                        </g>
                                        <g id="SvgjsG1430" class="apexcharts-annotations"></g>
                                    </svg>
                                    <div class="apexcharts-legend"></div>
                                </div>
                            </div>
                            <div class="resize-triggers">
                                <div class="contract-trigger"></div>
                            </div>
                        </div>
                    </div>
                </div>

                </span>{{ __('Total Number of Users') }}</p>
            </div>
        </div>
    </div>

    {{-- <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <div>
                            <p class="text-muted fw-medium mt-1 mb-2">{{ __('Workers') }}</p>
                            <h4>{{ $workers }}</h4>
                        </div>
                    </div>

                    <div class="col-4">
                        <div style="position: relative;">
                            <div id="radial-chart-2" style="min-height: 86.7px;">
                                <div id="apexchartskpzyj8ms"
                                    class="apexcharts-canvas apexchartskpzyj8ms apexcharts-theme-light"
                                    style="width: 58.0875px; height: 86.7px;"><svg id="SvgjsSvg1446" width="58.0875"
                                        height="86.7" xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg"
                                        xmlns:data="ApexChartsNS" transform="translate(0, 0)"
                                        style="background: transparent;">
                                        <g id="SvgjsG1448" class="apexcharts-inner apexcharts-graphical"
                                            transform="translate(-17.95625, -12)">
                                            <defs id="SvgjsDefs1447">
                                                <clipPath id="gridRectMaskkpzyj8ms">
                                                    <rect id="SvgjsRect1450" width="102" height="120"
                                                        x="-3" y="-1" rx="0" ry="0"
                                                        opacity="1" stroke-width="0" stroke="none"
                                                        stroke-dasharray="0" fill="#fff"></rect>
                                                </clipPath>
                                                <clipPath id="gridRectMarkerMaskkpzyj8ms">
                                                    <rect id="SvgjsRect1451" width="100" height="122"
                                                        x="-2" y="-2" rx="0" ry="0"
                                                        opacity="1" stroke-width="0" stroke="none"
                                                        stroke-dasharray="0" fill="#fff"></rect>
                                                </clipPath>
                                            </defs>
                                            <g id="SvgjsG1452" class="apexcharts-radialbar">
                                                <g id="SvgjsG1453">
                                                    <g id="SvgjsG1454" class="apexcharts-tracks">
                                                        <g id="SvgjsG1455"
                                                            class="apexcharts-radialbar-track apexcharts-track"
                                                            rel="1">
                                                            <path id="apexcharts-radialbarTrack-0"
                                                                d="M 48 16.919512195121953 A 31.080487804878047 31.080487804878047 0 1 1 47.994575431574326 16.91951266850485"
                                                                fill="none" fill-opacity="1"
                                                                stroke="rgba(242,242,242,0.85)" stroke-opacity="1"
                                                                stroke-linecap="butt" stroke-width="3.07087804878049"
                                                                stroke-dasharray="0" class="apexcharts-radialbar-area"
                                                                data:pathOrig="M 48 16.919512195121953 A 31.080487804878047 31.080487804878047 0 1 1 47.994575431574326 16.91951266850485">
                                                            </path>
                                                        </g>
                                                    </g>
                                                    <g id="SvgjsG1457">
                                                        <g id="SvgjsG1461"
                                                            class="apexcharts-series apexcharts-radial-series"
                                                            seriesName="seriesx1" rel="1" data:realIndex="0">
                                                            <path id="SvgjsPath1462"
                                                                d="M 48 16.919512195121953 A 31.080487804878047 31.080487804878047 0 1 1 19.182673515257143 36.35704434170984"
                                                                fill="none" fill-opacity="0.85"
                                                                stroke="rgba(69,203,133,0.85)" stroke-opacity="1"
                                                                stroke-linecap="butt"
                                                                stroke-width="3.1658536585365873" stroke-dasharray="0"
                                                                class="apexcharts-radialbar-area apexcharts-radialbar-slice-0"
                                                                data:angle="292" data:value="81" index="0"
                                                                j="0"
                                                                data:pathOrig="M 48 16.919512195121953 A 31.080487804878047 31.080487804878047 0 1 1 19.182673515257143 36.35704434170984">
                                                            </path>
                                                        </g>
                                                        <circle id="SvgjsCircle1458" r="24.5450487804878"
                                                            cx="48" cy="48"
                                                            class="apexcharts-radialbar-hollow"
                                                            fill="rgba(69, 203, 133, .25)"></circle>
                                                        <g id="SvgjsG1459" class="apexcharts-datalabels-group"
                                                            transform="translate(0, 0) scale(1)" style="opacity: 1;">
                                                            <text id="SvgjsText1460"
                                                                font-family="Helvetica, Arial, sans-serif"
                                                                x="48" y="53" text-anchor="middle"
                                                                dominant-baseline="auto" font-size="12px"
                                                                font-weight="400" fill="#373d3f"
                                                                class="apexcharts-text apexcharts-datalabel-value"
                                                                style="font-family: Helvetica, Arial, sans-serif;">{{ $workers }}</text>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                            <line id="SvgjsLine1463" x1="0" y1="0" x2="96"
                                                y2="0" stroke="#b6b6b6" stroke-dasharray="0"
                                                stroke-width="1" class="apexcharts-ycrosshairs"></line>
                                            <line id="SvgjsLine1464" x1="0" y1="0" x2="96"
                                                y2="0" stroke-dasharray="0" stroke-width="0"
                                                class="apexcharts-ycrosshairs-hidden"></line>
                                        </g>
                                        <g id="SvgjsG1449" class="apexcharts-annotations"></g>
                                    </svg>
                                    <div class="apexcharts-legend"></div>
                                </div>
                            </div>
                            <div class="resize-triggers">
                                <div class="contract-trigger"></div>
                            </div>
                        </div>
                    </div>
                </div>

                </span>{{ __('Total Number of Workers') }}</p>
            </div>
        </div>
    </div> --}}


</div>
