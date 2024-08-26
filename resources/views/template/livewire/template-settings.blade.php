@php
    $tabsData = $this->getTemplate()->getSettingsTabsData();
    $firstName = $tabsData[0]['name'];
@endphp
<x-only-laravel::template.block-setting-tabs :data="$tabsData" :activeTab="$firstName" :templateModel="$template" />
