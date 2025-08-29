<template>
    <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
        <!-- テニスラケット -->
        <g transform="rotate(-30 50 50)">
            <!-- ラケットのヘッド（楕円） -->
            <ellipse cx="35" cy="25" rx="18" ry="22" fill="none" stroke="currentColor" stroke-width="3"/>
            
            <!-- ラケットの網目 -->
            <line x1="20" y1="25" x2="50" y2="25" stroke="currentColor" stroke-width="1"/>
            <line x1="35" y1="8" x2="35" y2="42" stroke="currentColor" stroke-width="1"/>
            <line x1="25" y1="15" x2="45" y2="35" stroke="currentColor" stroke-width="1"/>
            <line x1="25" y1="35" x2="45" y2="15" stroke="currentColor" stroke-width="1"/>
            
            <!-- ラケットのハンドル -->
            <rect x="32" y="47" width="6" height="25" fill="currentColor" rx="3"/>
            
            <!-- ハンドルグリップ -->
            <line x1="30" y1="52" x2="40" y2="52" stroke="currentColor" stroke-width="1"/>
            <line x1="30" y1="57" x2="40" y2="57" stroke="currentColor" stroke-width="1"/>
            <line x1="30" y1="62" x2="40" y2="62" stroke="currentColor" stroke-width="1"/>
        </g>
        
        <!-- テニスボール -->
        <circle cx="70" cy="30" r="8" fill="currentColor"/>
        <path d="M 65 25 Q 70 30 75 25" stroke="white" stroke-width="1.5" fill="none"/>
        <path d="M 65 35 Q 70 30 75 35" stroke="white" stroke-width="1.5" fill="none"/>
    </svg>
</template>
