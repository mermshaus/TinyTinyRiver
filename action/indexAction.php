<?php

namespace mermshaus\TinyTinyRiver;

return function ($config) {
    $categoryId = (isset($_GET['categoryId']) && is_string($_GET['categoryId'])) ? (int)$_GET['categoryId'] : -1;

    $api = new TinyTinyRssApi($config['ttrss_apiurl'], $config['ttrss_user'], $config['ttrss_password']);

    $categories = $api->query('getCategories');

    $categories = array_filter($categories, function ($value) {
        return ($value['id'] > 0);
    });

    usort($categories, function ($a, $b) {
        if ($a['order_id'] < $b['order_id']) {
            return -1;
        }

        if ($a['order_id'] > $b['order_id']) {
            return 1;
        }

        return 0;
    });

    if ($categoryId === -1 && count($categories) > 0) {
        $categoryId = (int) $categories[0]['id'];
    }

    $categoriesById = array();
    foreach ($categories as $category) {
        $categoriesById[$category['id']] = $category;
    }


    $feeds = $api->query('getFeeds', array('cat_id' => $categoryId));
    $feedsById = array();
    foreach ($feeds as $feed) {
        $feedsById[$feed['id']] = $feed;
    }
    unset($feeds);

    $entries = $api->query('getHeadlines', array(
        'feed_id'      => $categoryId,
        'is_cat'       => true,
        'show_excerpt' => true, // unused ?
        'show_content' => true,
        'order_by'     => 'feed_dates',
        'limit'        => 150
    ));

    foreach ($entries as &$entry) {
        $entry['title']   = shortenString(cleanString($entry['title']), 150);
        $entry['content'] = shortenString(cleanString($entry['content']), 200);
        $entry['feed_icon_url'] = url('feedIcon', array('feedId' => $entry['feed_id']));
        $entry['feed_link'] = $feedsById[$entry['feed_id']]['feed_url'];
    }
    unset($entry);

    $entriesByDate = array();

    foreach ($entries as $entry) {
        $entryDate = date('Y-m-d', $entry['updated']);

        if (!array_key_exists($entryDate, $entriesByDate)) {
            $entriesByDate[$entryDate] = array();
        }

        $entriesByDate[$entryDate][] = $entry;
    }

    $tpl = array(
        'categoryTitle' => $categoriesById[$categoryId]['title'],
        'categoryId'    => $categoryId,
        'entriesByDate' => $entriesByDate,
        'categories'    => $categories
    );

    header('Content-Type: text/html; charset=UTF-8');

    render('index', $tpl);
};
