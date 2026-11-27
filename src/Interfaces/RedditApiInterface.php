<?php

namespace CodeWizz\RedditAPI\Interfaces;

use CodeWizz\RedditAPI\PhapperLive;

interface RedditApiInterface
{
    public function setDebug($debug): void;

    /**
     * Gets information about the current user's account.
     *
     * @return object An object representing the current user.
     */
    public function getMe();

    /**
     * Gets karma breakdown of current user.
     *
     * @return object Listing subreddits and corresponding karma values.
     */
    public function getMyKarmaBreakdown();

    /**
     * Gets current user's site preferences.
     *
     * @return object Object representing user's preferences.
     */
    public function getMyPrefs();

    /**
     * Update the current user's preferences.
     *
     * @param  array  $settings  An array of key-value pairs to update. Use getMyPrefs() to see possible values.
     *
     * @return object Object representing user's new preferences.
     */
    public function updateMyPrefs($settings);

    /**
     * Gets current user's trophies.
     *
     * @return object Listing of current user's trophies.
     */
    public function getMyTrophies();

    /**
     * Gets a list of the current user's friends.
     *
     * @return mixed|null Listing of users that are the current user's friends.
     */
    public function getMyFriends();

    /**
     * Gets a list of the current user's blocked users.
     *
     * @return object Listing of current user's blocked users.
     */
    public function getMyBlockedUsers();

    /**
     * Retrieves a list of all assigned user flair in the specified subreddit. Must be a mod of that subreddit.
     *
     * @param  string  $subreddit  Name of subreddit from which to retrieve flair list.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 1000.
     * @param  string|null  $after  Use 'next' attribute of previous call to retrieve next page.
     * @param  string|null  $before  Retrieve only flairs that are higher than this user ID on the list.
     *
     * @return object Listing of users that are assigned flair in the specified subreddit.
     */
    public function getUserFlairList($subreddit, $limit = 25, $after = null, $before = null);

    /**
     * Adds or modifies a flair template in a subreddit.
     *
     * @param  string  $subreddit  Name of subreddit to add flair template.
     * @param  string  $type  Specifies user or link flair template. One of 'link' or 'user'.
     * @param  string|null  $text  Flair text.
     * @param  string|null  $css_class  Flair CSS class.
     * @param  bool  $editable  Whether or not to allow users to edit the flair's text when assigning it.
     * @param  string|null  $template_id  The template ID of an existing flair to modify. If null, will add a new one.
     *
     * @return object Response to API call.
     */
    public function addFlairTemplate(
        $subreddit,
        $type,
        $text = null,
        $css_class = null,
        $editable = false,
        $template_id = null
    );

    /**
     * Deletes all flair templates of the selected type from the selected subreddit.
     *
     * @param  string  $subreddit  Subreddit of flairs to clear.
     * @param  string  $type  One of 'user' or 'link'.
     *
     * @return object|null Response to API call. Null if incorrect type.
     */
    public function clearFlairTemplates($subreddit, $type);

    /**
     * Deletes the selected flair template from the specified subreddit.
     * $template_id can be obtained with getUserFlairSelector and getLinkFlairSelector.
     *
     * @param  string  $subreddit  Subreddit from which to delete flair template.
     * @param  string  $template_id  ID of template to delete.
     *
     * @return object Response to API call.
     */
    public function deleteFlairTemplate($subreddit, $template_id);

    /**
     * Deletes a user's flair from the specified subreddit.
     *
     * @param  string  $subreddit  Subreddit in which to delete user flair.
     * @param  string  $user  Username of user whose flair to delete.
     *
     * @return object Response to API call.
     */
    public function deleteUserFlair($subreddit, $user);

    /**
     * Gets current flair and a list of possible flairs for the specified user in the specified subreddit.
     * Also useful for obtaining flair ID's.
     *
     * @param  string  $subreddit  Subreddit in which to view flair options.
     * @param  string|null  $user  Username for whom to view selection. Defaults to current user.
     *
     * @return object Response to API call.
     */
    public function getUserFlairSelector($subreddit, $user = null);

    /**
     * Gets current flair and a list of possible flairs for the specified link.
     *
     * @param  string  $thing_id  Thing ID of object to view flairs.
     *
     * @return object Response to API call.
     */
    public function getLinkFlairSelector($thing_id);

    /**
     * Selects a user flair to use from the flair selection list.
     *
     * @param  string  $subreddit  Subreddit in which to select flair.
     * @param  string  $user  Username of user to whom to apply flair. Mandatory, don't ask me why.
     * @param  string|null  $template_id  Template ID of template to select. Null will remove the user's flair.
     * @param  string|null  $text  Modified flair text, if allowed.
     *
     * @return object Response to API call.
     */
    public function selectUserFlair($subreddit, $user, $template_id = null, $text = null);

    /**
     * Applies a link flair template from the selection list to a link.
     *
     * @param  string  $thing_id  Thing ID of link to apply flair.
     * @param  string|null  $template_id  Template ID of template to apply to link. Null will remove the link's flair.
     * @param  string|null  $text  Modified flair text, if allowed.
     *
     * @return object Response to API call.
     */
    public function selectLinkFlair($thing_id, $template_id = null, $text = null);

    /**
     * Assigns the selected user custom flair text and CSS class in the specified subreddit. Mods only.
     *
     * @param  string  $subreddit  Subreddit in which to assign flair.
     * @param  string  $user  Username of user to assign flair.
     * @param  string|null  $text  Custom flair text.
     * @param  string|null  $css_class  Custom flair CSS class. If both fields are null, deletes flair.
     *
     * @return object Response to API call.
     */
    public function assignUserFlair($subreddit, $user, $text = null, $css_class = null);

    /**
     * Assigns the selected link custom flair text and CSS class in the specified subreddit. Mods only.
     *
     * @param  string  $subreddit  Subreddit in which to assign flair. Mandatory, don't ask me why.
     * @param  string  $thing_id  Thing ID of link to assign flair.
     * @param  string|null  $text  Custom flair text.
     * @param  string|null  $css_class  Custom flair CSS class. If both fields are null, deletes flair.
     *
     * @return object Response to API call.
     */
    public function assignLinkFlair($subreddit, $thing_id, $text = null, $css_class = null);

    /**
     * Selects whether or not to show the current user's flair in the selected subreddit.
     *
     * @param  string  $subreddit  Subreddit in which to enable or disable flair.
     * @param  bool  $show  True to show flair. False to hide flair.
     *
     * @return object Response to API call.
     */
    public function showMyFlair($subreddit, $show = true);

    /**
     * Updates all options in a subreddit's flair configuration.
     *
     * @param  string  $subreddit  Subreddit in which to configure flair.
     * @param  bool  $user_enabled  Whether or not user flair is displayed.
     * @param  string  $user_position  On which side to display user flair. One of 'left' or 'right'.
     * @param  bool  $user_self_assign  Whether or not users can select their own user flair.
     * @param  string  $link_position  On which side to display links' flair. One of 'left', 'right', or 'none'.
     * @param  bool  $link_self_assign  Whether or not users can select their own links' flair.
     *
     * @return object|null Response to API call. Null if invalid arguments.
     */
    public function configureSubredditFlair(
        $subreddit,
        $user_enabled,
        $user_position,
        $user_self_assign,
        $link_position,
        $link_self_assign
    );

    /**
     * UNTESTED
     * Gild a link or comment, which gives the author reddit gold. Must have sufficient gold creddits.
     * Reddit's documentation is odd, indicating that the thing ID is required both in the URL and the POST parameters.
     *
     * @param  string  $thing_id  Thing ID of link or comment to gild.
     *
     * @return object Response to API call.
     */
    public function gild($thing_id);

    /**
     * UNTESTED
     * Give the specified user the specified months of reddit gold. Must have sufficient gold creddits.
     * Reddit's documentation is odd, indicating that the username is required both in the URL and the POST parameters.
     *
     * @param  string  $user  Username of user to whom to give gold.
     * @param  int  $months  Number of months to give reddit gold.
     *
     * @return object Response to API call.
     */
    public function giveGold($user, $months = 1);

    /**
     * Submits a new link post.
     *
     * @param  string  $subreddit  Subreddit in which to post link.
     * @param  string  $title  Title of post.
     * @param  string  $url  Link to post.
     * @param  bool  $send_replies  Send comment replies to the current user's inbox. True to enable, false to disable.
     * @param  bool  $distinguish  Whether or not it should be mod distinguished (for modded subreddits only).
     *
     * @return object Response to API call.
     */
    public function submitLinkPost($subreddit, $title, $url, $send_replies = true, $distinguish = false);

    /**
     * Submits a new text post.
     *
     * @param  string  $subreddit  Subreddit in which to post.
     * @param  string  $title  Title of post.
     * @param  string|null  $text  Text of post.
     * @param  bool  $send_replies  Send comment replies to the current user's inbox. True to enable, false to disable.
     * @param  bool  $distinguish  Whether or not it should be mod distinguished (for modded subreddits only).
     *
     * @return object Response to API call.
     */
    public function submitTextPost($subreddit, $title, $text = null, $send_replies = true, $distinguish = false);

    /**
     * Comments on an object.
     *
     * @param  string  $parent  Thing ID of parent object on which to comment. Could be link, text post, or comment.
     * @param  string  $text  Comment text.
     * @param  bool  $distinguish  Whether or not it should be mod distinguished (for modded subreddits only).
     *
     * @return object Response to API call.
     */
    public function comment($parent, $text, $distinguish = false);

    /**
     * Deletes a post or comment.
     *
     * @param  string  $thing_id  Thing ID of object to delete. Could be link, text post, or comment.
     *
     * @return object Response to API call, probably empty.
     */
    public function delete($thing_id);

    /**
     * Edits the text of a comment or text post.
     *
     * @param  string  $thing_id  Thing ID of text object to edit. Could be text post or comment.
     * @param  string  $text  New text to replace the old.
     *
     * @return object Response to API call, probably object of thing that was just edited.
     */
    public function editText($thing_id, $text);

    /**
     * Hides a post from user's listings.
     *
     * @param  string|array  $thing_ids  String or array of thing ID's of links to hide.
     *
     * @return bool|null Response to API call.
     */
    public function hide($thing_ids): ?bool;

    /**
     * Unhides a post from user's hidden posts.
     *
     * @param  string|array  $thing_ids  String or array of thing ID's of links to unhide.
     *
     * @return bool|null Returns true if success. Null if failed.
     */
    public function unhide($thing_ids): ?bool;

    /**
     * Gives a listing of information on objects.
     *
     * @param  string|array  $thing_ids  String or array of single or multiple thing ID's.
     *
     * @return object Listing objects requested.
     */
    public function getInfo($thing_ids);

    /**
     * Marks a post as NSFW.
     *
     * @param  string  $thing_id  Thing ID of post to mark as NSFW.
     *
     * @return object Response to API call, probably empty.
     */
    public function markNSFW($thing_id);

    /**
     * Unmarks a post as NSFW.
     *
     * @param  string  $thing_id  Thing ID of post to unmark as NSFW.
     *
     * @return object Response to API call, probably empty.
     */
    public function unmarkNSFW($thing_id);

    /**
     * Get comments in a tree that are hidden by "load more comments".
     * NOTE: Only make one request for this at a time. Higher concurrency will result in an error.
     *
     * @param  string  $link_id  Fullname (thing ID) of link/post of the comment tree.
     * @param  string|array  $comment_ids  ID36 or fullname of one or more parent comments for which to retrieve children.
     *
     * @return object Complex object containing comment's children.
     */
    public function getCommentChildren($link_id, $comment_ids);

    /**
     * Reports a post, comment, or message.
     *
     * @param  string  $thing_id  Thing ID of object to report.
     * @param  null  $reason  The reason for the report. Must be <100 characters.
     *
     * @return object Response to API call.
     */
    public function report($thing_id, $reason = null);

    /**
     * Saves a post or comment in the selected category.
     *
     * @param  string  $thing_id  Thing ID of object to save. Can be post or comment.
     * @param  null  $category  Category in which to save object. Defaults to none.
     *
     * @return object Response to API call, probably empty.
     */
    public function save($thing_id, $category = null);

    /**
     * Unsaves a post or comment from the current user's saved posts.
     *
     * @param  string  $thing_id  Thing ID of object to unsave. Can be post or comment.
     *
     * @return object Response to API call, probably empty.
     */
    public function unsave($thing_id);

    /**
     * Gets the current user's save categories.
     *
     * @return object Contains an array of categories.
     */
    public function getSavedCategories();

    /**
     * Toggles whether or not the current user should receive replies to a specific post or comment to their inbox.
     *
     * @param  string  $thing_id  Thing ID of object to toggle.
     * @param  bool  $state  State of inbox replies. True to receive, false for not.
     *
     * @return object Response to API call, probably empty.
     */
    public function sendInboxReplies($thing_id, $state = true);

    /**
     * Store that the current user has visited a certain link.
     *
     * @param  string|array  $thing_ids  String or array of thing ID's of links to store as visited.
     *
     * @return object Response to API call, probably empty.
     */
    public function storeVisits($thing_ids);

    /**
     * VOTES MUST BE CAST BY A HUMAN!!
     * Proxying a person's single vote is okay, but bots should not use vote functions on their own.
     *
     * Upvotes a post or comment.
     *
     * @param  string  $thing_id  Thing ID of object to upvote.
     *
     * @return object Response to API call, probably empty.
     */
    public function upvote($thing_id);

    /**
     * Downvotes a post or comment.
     *
     * @param  string  $thing_id  Thing ID of object to downvote.
     *
     * @return object Response to API call, probably empty.
     */
    public function downvote($thing_id);

    /**
     * Resets the current user's vote on a post or comment.
     *
     * @param  string  $thing_id  Thing ID of object to reset vote.
     *
     * @return object Response to API call, probably empty.
     */
    public function unvote($thing_id);

    /**
     * Retrieves a listing of links by their specified thing ID.
     *
     * @param  string  $thing_ids  Thing ID's of links to retrieve.
     *
     * @return object A listing of links.
     */
    public function getLinksById($thing_ids);

    /**
     * Retrieves a listing of comments and children for a link and optionally a specific comment.
     *
     * @param  string  $link_id  ID36 or fullname of link for comments to fetch.
     * @param  string|null  $comment_id  Optional, ID36 or fullname of a single comment to fetch with children, much like permalink.
     * @param  int|null  $context  Number of levels up of parent comments to retrieve. Only applicable to child comments.
     * @param  int|null  $depth  Depth of child comments to retrieve.
     * @param  int|null  $limit  Limit of comments to retrieve.
     * @param  string|null  $sort  How to sort the comments, one of 'confidence', 'top', 'new', 'hot', 'controversial', 'old', 'random', 'qa'
     * @param  bool  $show_edits  Show edited comments, perhaps? Not well documented by reddit.
     * @param  bool  $show_more  Include links to show more comments, maybe? Not well documented by reddit.
     *
     * @return object Listing of link and specified comment(s).
     */
    public function getComments(
        $link_id,
        $comment_id = null,
        $context = null,
        $depth = null,
        $limit = null,
        $sort = null,
        $show_edits = false,
        $show_more = false
    );

    /**
     * Retrieves the specified link and a listing of other links that are to duplicate destinations.
     *
     * @param  string  $thing_id  ID36 or fullname of link to check for duplicates.
     * @param  int  $limit  Limit of duplicate links to retrieve.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of original link and listing of duplicate links.
     */
    public function getDuplicateLinks($thing_id, $limit = 25, $after = null, $before = null);

    /**
     * Retrieves the hot listing for the optionally specified subreddit.
     *
     * @param  string|null  $subreddit  Subreddit of listing to retrieve. If none, defaults to front page.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return mixed|null Returns listing object on success. Null if failed.
     */
    public function getHot($subreddit = null, $limit = 25, $after = null, $before = null);

    /**
     * Retrieves the new listing for the optionally specified subreddit.
     *
     * @param  string|null  $subreddit  Subreddit of listing to retrieve. If none, defaults to front page.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return mixed|null Returns listing object on success. Null if failed.
     */
    public function getNew($subreddit = null, $limit = 25, $after = null, $before = null);

    /**
     * Retrieves the controversial listing for the optionally specified subreddit.
     *
     * @param  string|null  $subreddit  Subreddit of listing to retrieve. If none, defaults to front page.
     * @param  string  $time  Time constraint for age of items on list. One of hour, day, week, month, year, all.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return mixed|null Returns listing object on success. Null if failed.
     */
    public function getControversial($subreddit = null, $time = 'all', $limit = 25, $after = null, $before = null);

    /**
     * Retrieves the top listing for the optionally specified subreddit.
     *
     * @param  string|null  $subreddit  Subreddit of listing to retrieve. If none, defaults to front page.
     * @param  string  $time  Time constraint for age of items on list. One of 'hour', 'day', 'week', 'month', 'year', 'all'.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return mixed|null Returns listing object on success. Null if failed.
     */
    public function getTop($subreddit = null, $time = 'all', $limit = 25, $after = null, $before = null);

    /**
     * NOT CURRENTLY SUPPORTED BY REDDIT. HERE ANYWAY IN CASE IT IS IN THE FUTURE.
     * Retrieves a random link from the optionally specified subreddit. If none, choose from any subreddit.
     *
     * @param  string|null  $subreddit  Subreddit from which to retrieve a random link.
     *
     * @return object Who knows? Probably a listing of a single link.
     */
    public function getRandom($subreddit = null);

    /**
     * Retrieves a list of links that are the result of a search of the specified link's title.
     *
     * @param  string  $thing_id  ID36 or fullname of link to search with.
     * @param  int  $limit  Upper limit of the number of links to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of original link and listing of related links.
     */
    public function getRelatedLinks($thing_id, $limit = 25, $after = null, $before = null);

    /**
     * Creates a new live thread. To use an existing one, use attachLiveThread().
     *
     * @param  string  $title  The thread's title.
     * @param  string|null  $description  The thread's description.
     * @param  string|null  $resources  The thread's resources section in the sidebar.
     * @param  bool  $nsfw  Whether or not the thread is NSFW. Prompts guests to continue when visiting.
     *
     * @return PhapperLive|null New PHP object representing a reddit live thread.
     */
    public function createLiveThread($title, $description = null, $resources = null, $nsfw = false): ?PhapperLive;

    /**
     * Uses an existing live thread to create a Live object. You do not necessarily need to be a contributor to attach.
     *
     * @param  string  $thread_id  Thread ID of the thread to attach.
     *
     * @return PhapperLive Returns the resulting PHP Live object.
     */
    public function attachLiveThread($thread_id): PhapperLive;

    /**
     * Block a user based on the thing ID of a *message* they sent you. Does not work directly on user objects.
     *
     * @param  string  $thing_id  Thing ID of message that the user to block sent you.
     *
     * @return object Response to API call, probably empty.
     */
    public function blockByMessage($thing_id);

    /**
     * CURRENTLY NOT SUPPORTED WITH OAUTH.
     * Collapse one or more messages in modmail.
     *
     * @param  string|array  $thing_ids  Comma-separated or array of thing ID's of messages to collapse.
     *
     * @return object Undetermined.
     */
    public function collapseMessage($thing_ids);

    /**
     * CURRENTLY NOT SUPPORTED WITH OAUTH.
     * Uncollapse one or more messages in modmail.
     *
     * @param  string|array  $thing_ids  Comma-separated or array of thing ID's of messages to uncollapse.
     *
     * @return object Undetermined.
     */
    public function uncollapseMessage($thing_ids);

    /**
     * Sends a message to a user or subreddit.
     *
     * @param  string  $to  Username or subreddit to send to.
     * @param  string  $subject  Subject of message.
     * @param  string  $body  Body of message.
     * @param  string|null  $from_subreddit  Optionally the name of the subreddit from which to send the message.
     *
     * @return object Response to API call.
     */
    public function composeMessage($to, $subject, $body, $from_subreddit = null);

    /**
     * Deletes a message from the recipient's inbox.
     * Be aware that messages sent both from and to yourself cannot be deleted.
     *
     * @param $thing_id string Thing ID of message to delete.
     *
     * @return mixed Response to API call.
     */
    public function deleteMessage($thing_id);

    /**
     * Queues a job for all of your messages to be marked as read.
     *
     * @return string Raw body response from reddit since it's not in JSON.
     */
    public function markAllMessagesAsRead(): string;

    /**
     * Marks one or more messages as read.
     *
     * @param  string|array  $thing_ids  A comma-separated string or array of one or more message thing ID's (t4_).
     *
     * @return object Response to API call, probably empty.
     */
    public function markMessageRead($thing_ids);

    /**
     * Marks one or more messages as unread.
     *
     * @param  string|array  $thing_ids  A comma-separated string or array of one or more message thing ID's (t4_).
     *
     * @return object Response to API call, probably empty.
     */
    public function markMessageUnread($thing_ids);

    /**
     * Unblock a subreddit using a message they sent you.
     *
     * @param  string  $thing_id  Thing ID of a message sent by the subreddit to unblock.
     *
     * @return object Response to API call.
     */
    public function unblockSubredditByMessage($thing_id);

    /**
     * Retrieves the current user's personal message inbox.
     *
     * @param  int  $limit  Upper limit of the number of links to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of messages in user's inbox.
     */
    public function getInbox($limit = 25, $after = null, $before = null);

    /**
     * Retrieves the current user's unread personal messages.
     *
     * @param  int  $limit  Upper limit of the number of links to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of unread messages in user's inbox.
     */
    public function getUnread($limit = 25, $after = null, $before = null);

    /**
     * Retrieves the current user's sent personal messages.
     *
     * @param  int  $limit  Upper limit of the number of links to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of unread messages in user's inbox.
     */
    public function getSent($limit = 25, $after = null, $before = null);

    /**
     * Retrieves modmail messages.
     *
     * @param  string  $subreddit  Subreddit for which to retrieve modmail. 'mod' means all moderated subreddits.
     * @param  bool  $messages_read  Whether or not to turn off the orangered mail icon. Does not mark each message as read.
     * @param  int  $limit  Upper limit of the number of message threads to retrieve. Maximum of 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of modmail messages.
     */
    public function getModmail($subreddit = 'mod', $messages_read = false, $limit = 25, $after = null, $before = null);

    /**
     * Retrieve a list of all of reddit's OAuth2 scopes.
     *
     * @return object Contains several objects representing each OAuth2 scope
     */
    public function getOAuthScopes();

    /**
     * Toggles contest mode on a post.
     *
     * @param  string  $thing_id  Thing ID of post to toggle contest mode.
     * @param  bool  $state  True to enable contest mode, false to disable.
     *
     * @return object Response to API call, probably empty.
     */
    public function setContestMode($thing_id, $state = true);

    /**
     * Stickies a post at the top of the subreddit.
     *
     * @param  string  $thing_id  Thing ID of post to sticky.
     * @param  int  $num  Position of new sticky. 1 for top, 2 for bottom. Defaults to 2.
     *
     * @return object Response to API call.
     */
    public function stickyPost($thing_id, $num = 2);

    /**
     * Unsticky a post from the top of a subreddit.
     *
     * @param  string  $thing_id  Thing ID of post to unsticky.
     *
     * @return object Response to API call.
     */
    public function unstickyPost($thing_id);

    /**
     * Sets the default sort of a link's comments.
     *
     * @param  string  $thing_id  Thing ID of link to set suggested sort.
     * @param  string  $sort  Sort method. One of: 'confidence', 'top', 'new', 'hot', 'controversial', 'old', 'random', 'qa'
     *
     * @return object Response to API call, probably empty.
     */
    public function setSuggestedSort($thing_id, $sort);

    /**
     * Clears the default sort of a link's comments.
     *
     * @param  string  $thing_id  Thing ID of link to clear suggested sort.
     *
     * @return object Response to API call, probably empty.
     */
    public function clearSuggestedSort($thing_id);

    /**
     * Mod distinguish a post or comment.
     *
     * @param  string  $thing_id  Thing ID of object to distinguish.
     * @param  bool  $how  True to set [M] distinguish. False to undistinguish.
     *
     * @return object Response to API call.
     */
    public function distinguish($thing_id, $how = true);

    /**
     * Retrieves recent entries from the moderation log for the specified subreddit.
     *
     * @param  string  $subreddit  Subreddit of log to retrieve. All moderated subreddits by default.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 500.
     * @param  string|null  $after  Obtain the page of the results that come after the specified ModAction.
     * @param  string|null  $mod  Filter by moderator.
     * @param  string|null  $action  Filter by mod action.
     * @param  string|null  $before  Obtain the page of the results that come before the specified ModAction.
     *
     * @return object Listing object with modaction children.
     */
    public function getModerationLog(
        $subreddit = 'mod',
        $limit = 25,
        $after = null,
        $mod = null,
        $action = null,
        $before = null
    );

    /**
     * Retrieves a list of things that have been reported in the specified subreddit.
     *
     * @param  string  $subreddit  Subreddit of items to retrieve. All moderated subreddits by default.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     * @param  null  $only  Obtain only links or comments. One of 'links' or 'comments'. Null for both.
     *
     * @return mixed|null Returns a listing object with link and/or comment children.
     */
    public function getReports($subreddit = 'mod', $limit = 25, $after = null, $before = null, $only = null);

    /**
     * Retrieves a list of things that have been marked as spam in the specified subreddit.
     *
     * @param  string  $subreddit  Subreddit of items to retrieve. All moderated subreddits by default.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     * @param  null  $only  Obtain only links or comments. One of 'links' or 'comments'. Null for both.
     *
     * @return mixed|null Returns a listing object with link and/or comment children.
     */
    public function getSpam($subreddit = 'mod', $limit = 25, $after = null, $before = null, $only = null);

    /**
     * Retrieves a list of things that have been placed in the modqueue of the specified subreddit.
     *
     * @param  string  $subreddit  Subreddit of items to retrieve. All moderated subreddits by default.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     * @param  null  $only  Obtain only links or comments. One of 'links' or 'comments'. Null for both.
     *
     * @return mixed|null Returns a listing object with link and/or comment children.
     */
    public function getModqueue($subreddit = 'mod', $limit = 25, $after = null, $before = null, $only = null);

    /**
     * Retrieves a list of things that have not been moderated in the specified subreddit.
     *
     * @param  string  $subreddit  Subreddit of items to retrieve. All moderated subreddits by default.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return mixed|null Returns a listing object with link and/or comment children.
     */
    public function getUnmoderated($subreddit = 'mod', $limit = 25, $after = null, $before = null);

    /**
     * Retrieves a list of comments that have been edited by the author in the specified subreddit.
     *
     * @param  string  $subreddit  Subreddit of items to retrieve. All moderated subreddits by default.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return mixed|null Returns a listing object with link and/or comment children.
     */
    public function getEditedComments($subreddit = 'mod', $limit = 25, $after = null, $before = null);

    /**
     * Accepts a moderator invitation for the specified subreddit. You must have a pending invitation for that subreddit.
     *
     * @param  string  $subreddit  Subreddit to accept invitation.
     *
     * @return object Response to API call.
     */
    public function acceptModeratorInvite($subreddit);

    /**
     * Marks the specified thing as approved.
     *
     * @param  string  $thing_id  Thing ID of object to be approved.
     *
     * @return object Response to API call, probably empty.
     */
    public function approve($thing_id);

    /**
     * Removes a post or comment from a subreddit.
     *
     * @param  string  $thing_id  Thing ID of object to remove.
     *
     * @return object Response to API call, probably empty.
     */
    public function remove($thing_id);

    /**
     * Removes a post or comment from a subreddit as spam.
     *
     * @param  string  $thing_id  Thing ID of object to remove.
     *
     * @return object Response to API call, probably empty.
     */
    public function spam($thing_id);

    /**
     * Ignores reports for the specified thing.
     *
     * @param  string  $thing_id  Thing ID of object to be ignored.
     *
     * @return object Response to API call, probably empty.
     */
    public function ignoreReports($thing_id);

    /**
     * Unignores reports for the specified thing.
     *
     * @param  string  $thing_id  Thing ID of object to be unignored.
     *
     * @return object Response to API call, probably empty.
     */
    public function unignoreReports($thing_id);

    /**
     * Abdicate approved submitter status in a subreddit.
     *
     * @param  string  $subreddit  Name of subreddit to leave.
     *
     * @return object Response to API call, probably empty.
     */
    public function leaveContributor($subreddit);

    /**
     * Abdicate moderator status in a subreddit.
     *
     * @param  string  $subreddit  Name of subreddit to leave.
     *
     * @return object Response to API call, probably empty.
     */
    public function leaveModerator($subreddit);

    /**
     * Ban a user from the selected subreddit.
     *
     * @param  string  $subreddit  Subreddit from which to ban user.
     * @param  string  $user  Username of user to ban.
     * @param  string|null  $note  Ban note in banned users list. Not shown to user.
     * @param  string|null  $message  Ban message sent to user.
     * @param  int|null  $duration  Duration of ban in days.
     *
     * @return object Response to API call.
     */
    public function ban($subreddit, $user, $note = null, $message = null, $duration = null);

    /**
     * Unban a user from a subreddit.
     *
     * @param  string  $subreddit  Subreddit from which to unban the user.
     * @param  string  $user  Username of user to unban.
     *
     * @return object Response to API call, probably empty.
     */
    public function unban($subreddit, $user);

    /**
     * Add a user as a contributor to a subreddit.
     *
     * @param  string  $subreddit  Subreddit to which to add user.
     * @param  string  $user  Username of user to add.
     *
     * @return object Response to API call.
     */
    public function addContributor($subreddit, $user);

    /**
     * Remove a user as a contributor from a subreddit.
     *
     * @param  string  $subreddit  Subreddit from which to remove the user.
     * @param  string  $user  Username of user to remove.
     *
     * @return object Response to API call, probably empty..
     */
    public function removeContributor($subreddit, $user);

    /**
     * Invite a user to become a moderator to a subreddit.
     *
     * @param  string  $subreddit  Subreddit to which to invite user.
     * @param  string  $user  Username of user to invite.
     * @param  bool  $perm_all  If the user should have full permissions.
     * @param  bool  $perm_access  If the user should have the 'access' permission.
     * @param  bool  $perm_config  If the user should have the 'config' permission.
     * @param  bool  $perm_flair  If the user should have the 'flair' permission.
     * @param  bool  $perm_mail  If the user should have the 'mail' permission.
     * @param  bool  $perm_posts  If the user should have the 'posts' permission.
     * @param  bool  $perm_wiki  If the user should have the 'wiki' permission.
     *
     * @return object Response to API call.
     */
    public function inviteModerator(
        $subreddit,
        $user,
        $perm_all = true,
        $perm_access = false,
        $perm_config = false,
        $perm_flair = false,
        $perm_mail = false,
        $perm_posts = false,
        $perm_wiki = false
    );

    /**
     * Remove an existing moderator as a moderator from a subreddit. To revoke an invitation, use uninviteModerator().
     *
     * @param  string  $subreddit  Subreddit from which to remove a user as a moderator.
     * @param  string  $user  Username of user to remove
     *
     * @return object Response to API call, probably empty.
     */
    public function removeModerator($subreddit, $user);

    /**
     * Revoke a user's pending invitation to moderate a subreddit. To remove an existing moderator, use removeModerator().
     *
     * @param  string  $subreddit  Subreddit from which to revoke a user's invitation.
     * @param  string  $user  User whose invitation to revoke.
     *
     * @return object Response to API call, probably empty.
     */
    public function uninviteModerator($subreddit, $user);

    /**
     * Modify an existing moderator's permission set. To modify an invited moderator's permissions, use setInvitationPermissions().
     *
     * @param  string  $subreddit  Subreddit in which to edit a user's permissions
     * @param  string  $user  Username of user to edit permissions.
     * @param  bool  $perm_all  If the user should have full permissions.
     * @param  bool  $perm_access  If the user should have the 'access' permission.
     * @param  bool  $perm_config  If the user should have the 'config' permission.
     * @param  bool  $perm_flair  If the user should have the 'flair' permission.
     * @param  bool  $perm_mail  If the user should have the 'mail' permission.
     * @param  bool  $perm_posts  If the user should have the 'posts' permission.
     * @param  bool  $perm_wiki  If the user should have the 'wiki' permission.
     *
     * @return object Response to API call.
     */
    public function setModeratorPermissions(
        $subreddit,
        $user,
        $perm_all = true,
        $perm_access = false,
        $perm_config = false,
        $perm_flair = false,
        $perm_mail = false,
        $perm_posts = false,
        $perm_wiki = false
    );

    /**
     * Modify an invited moderator's permission set. To modify an existing moderator's permissions, use setModeratorPermissions().
     *
     * @param  string  $subreddit  Subreddit in which to edit a user's permissions
     * @param  string  $user  Username of user to edit permissions.
     * @param  bool  $perm_all  If the user should have full permissions.
     * @param  bool  $perm_access  If the user should have the 'access' permission.
     * @param  bool  $perm_config  If the user should have the 'config' permission.
     * @param  bool  $perm_flair  If the user should have the 'flair' permission.
     * @param  bool  $perm_mail  If the user should have the 'mail' permission.
     * @param  bool  $perm_posts  If the user should have the 'posts' permission.
     * @param  bool  $perm_wiki  If the user should have the 'wiki' permission.
     *
     * @return object Response to API call.
     */
    public function setInvitationPermissions(
        $subreddit,
        $user,
        $perm_all = true,
        $perm_access = false,
        $perm_config = false,
        $perm_flair = false,
        $perm_mail = false,
        $perm_posts = false,
        $perm_wiki = false
    );

    /**
     * Ban a user from contributing to a subreddit's wiki.
     *
     * @param  string  $subreddit  Subreddit from which to ban user.
     * @param  string  $user  Username of user to ban.
     * @param  string|null  $note  Ban note in banned users list. Not shown to user.
     * @param  int|null  $duration  Duration of ban in days.
     *
     * @return object Response to API call.
     */
    public function wikiBan($subreddit, $user, $note = null, $duration = null);

    /**
     * Unban a user from a subreddit's wiki.
     *
     * @param  string  $subreddit  Subreddit from which to unban the user.
     * @param  string  $user  Username of user to unban.
     *
     * @return object Response to API call, probably empty.
     */
    public function wikiUnban($subreddit, $user);

    /**
     * Add a user as a contributor to a subreddit's wiki.
     *
     * @param  string  $subreddit  Subreddit to which to add user.
     * @param  string  $user  Username of user to add.
     *
     * @return object Response to API call.
     */
    public function addWikiContributor($subreddit, $user);

    /**
     * Remove a user as a contributor from a subreddit's wiki.
     *
     * @param  string  $subreddit  Subreddit from which to remove the user.
     * @param  string  $user  Username of user to remove.
     *
     * @return mixed|null Response to API call, probably empty.
     */
    public function removeWikiContributor($subreddit, $user);

    /**
     * Mute a user in the specified subreddit by username.
     *
     * @param  string  $subreddit  Subreddit in which to mute the user.
     * @param  string  $user  Username of user to mute.
     * @param  string|null  $note  Mute note in muted users list. Not shown to user.
     *
     * @return object Response to API call.
     */
    public function mute($subreddit, $user, $note = null);

    /**
     * Unmute a user in the specified subreddit by username.
     *
     * @param  string  $subreddit  Subreddit to which to unmute the user.
     * @param  string  $user  Username of user to unmute.
     *
     * @return object Response to API call, probably empty.
     */
    public function unmute($subreddit, $user);

    /**
     * Mute a user from a subreddit based on the thing ID of a message they sent.
     *
     * @param  string  $thing_id  Thing ID of the message author to be muted.
     *
     * @return object Response to API call, probably empty.
     */
    public function muteUserByMessage($thing_id);

    /**
     * Unmute a user from a subreddit based on the thing ID of a message they sent.
     *
     * @param  string  $thing_id  Thing ID of the message author to be unmuted.
     *
     * @return object Response to API call, probably empty.
     */
    public function unmuteUserByMessage($thing_id);

    /**
     * Lock a post and prevent any new comments by non-moderators.
     *
     * @param  string  $thing_id  Thing ID of post to lock. Must be a post, not a comment.
     *
     * @return object Response to API call, probably empty.
     */
    public function lockThread($thing_id);

    /**
     * Unlock a post and allow any new comments.
     *
     * @param  string  $thing_id  Thing ID of post to unlock.
     *
     * @return object Response to API call, probably empty.
     */
    public function unlockThread($thing_id);

    /**
     * Copy an existing multireddit to your own set.
     *
     * @param  string  $from_user  Owner of multireddit to copy.
     * @param  string  $from_name  Name of multireddit to copy.
     * @param  string  $to_name  Name of destination multireddit.
     *
     * @return object Resulting multireddit object.
     */
    public function multiCopy($from_user, $from_name, $to_name);

    /**
     * Retrieves a list of multireddits that are owned by the current user.
     *
     * @return array Contains multireddit objects.
     */
    public function multiGetMine(): array;

    /**
     * Retrieves a list of multireddits owned by the specified user.
     *
     * @param  string  $user  Username of user for which to retrieve owned multireddits.
     * @param  bool  $expand_srs  Obtain extra details about the subreddits of each multireddit.
     *
     * @return array Multireddit objects.
     */
    public function multiGetUser($user, $expand_srs = false): array;

    /**
     * Renames a subreddit. Functions like copying the existing subreddit then deleting the old one.
     *
     * @param  string  $from_name  Name of multireddit to rename.
     * @param  string  $to_name  Destination name.
     *
     * @return object Resulting multireddit object.
     */
    public function multiRename($from_name, $to_name);

    /**
     * Retrieves a multireddit.
     *
     * @param  string  $user  Owner of multireddit to retrieve.
     * @param  string  $name  Name of multireddit to retrieve.
     *
     * @return object Multireddit object.
     */
    public function multiGet($user, $name);

    /**
     * Create a multireddit. If multireddit of name already exists, an incremented number is appended to the end.
     *
     * @param  string  $name  Name (and URL) of new multireddit.
     * @param  string|array  $subreddits  Array or comma-delimited string of one or more subreddits that should go in the multireddit.
     * @param  string|null  $description  Multireddit sidebar text.
     * @param  string  $visibility  One of 'public', 'private', 'hidden'. Hidden multireddits will not be visible to you except through the API.
     * @param  string  $weighting_scheme  One of 'classic', 'fresh'.
     * @param  string|null  $icon  Not really used, but see https://www.reddit.com/dev/api#POST_api_multi_{multipath} for possible values.
     * @param  string  $key_color  Not really used, but can be hex color.
     *
     * @return object Multireddit object of new multireddit.
     */
    public function multiCreate(
        $name,
        $subreddits = [],
        $description = null,
        $visibility = 'private',
        $weighting_scheme = 'classic',
        $icon = null,
        $key_color = '#cee3f8'
    );

    /**
     * Update an existing multireddit. If one of the specified name does not exits, one will be created.
     * Fields to not be updated should be null.
     *
     * @param  string  $name  Name (and URL) of new multireddit.
     * @param  string|null  $subreddits  Array or comma-delimited string of one or more subreddits that should go in the multireddit.
     * @param  string|null  $description  Multireddit sidebar text.
     * @param  string  $visibility  One of 'public', 'private', 'hidden'. Hidden multireddits will not be visible to you except through the API.
     * @param  string|null  $weighting_scheme  One of 'classic', 'fresh'.
     * @param  string|null  $icon  Not really used, but see https://www.reddit.com/dev/api#POST_api_multi_{multipath} for possible values.
     * @param  string|null  $key_color  Not really used, but can be hex color.
     *
     * @return object Multireddit object of resulting multireddit.
     */
    public function multiEdit(
        $name,
        $subreddits = null,
        $description = null,
        $visibility = null,
        $weighting_scheme = null,
        $icon = null,
        $key_color = null
    );

    /**
     * Deletes the specified multireddit.
     *
     * @param  string  $name  Name of multireddit to delete.
     *
     * @return null Response to API call, probably null.
     */
    public function multiDelete($name);

    /**
     * Get the description/sidebar for the specified multireddit.
     *
     * @param  string  $user  Owner of multireddit.
     * @param  string  $name  Name of multireddit.
     *
     * @return object Response to API call, a LabeledMultiDescription object.
     */
    public function multiGetDescription($user, $name);

    /**
     * Edit the description/sidebar for the specified multireddit.
     *
     * @param  string  $name  Name of multireddit.
     * @param  string  $description  New description.
     *
     * @return object Response to API call, LabeledMultiDescription object.
     */
    public function multiEditDescription($name, $description);

    /**
     * Get information about the specified subreddit in the specified multireddit. Kinda useless, since it only returns the name at this point.
     *
     * @param  string  $user  Owner of multireddit.
     * @param  string  $name  Name of multireddit.
     * @param  string  $subreddit  Subreddit for which to obtain information.
     *
     * @return object Response to API call, only contains subreddit name.
     */
    public function multiGetSubreddit($user, $name, $subreddit);

    /**
     * Add the specified subreddit to the specified multireddit.
     *
     * @param  string  $name  Name of multireddit.
     * @param  string  $subreddit  Name of subreddit to add.
     *
     * @return object Response to API call, only contains the subreddit name.
     */
    public function multiAddSubreddit($name, $subreddit);

    /**
     * Remove the specified subreddit from the specified multireddit.
     *
     * @param  string  $name  Name of multireddit.
     * @param  string  $subreddit  Name of subreddit to remove.
     *
     * @return object Response to API call, probably null.
     */
    public function multiRemoveSubreddit($name, $subreddit);

    /**
     * Perform a search query.
     * Somewhat untested due to the complexity of and possible combinations to use in the search function.
     *
     * @param  string  $query  Query of which to search.
     * @param  string|null  $subreddit  Subreddit to which to restrict search.
     * @param  string|null  $sort  Sort results by one of 'relevance', 'hot', 'top', 'new', 'comments'. Defaults to 'relevance'.
     * @param  string|null  $time  One of 'hour', 'day', 'week', 'month', 'year', 'all'. Defaults to all.
     * @param  string|null  $type  Comma-delimited list of result types: 'sr', 'link', or null.
     * @param  int  $limit  Upper limit of results to return.
     * @param  string|null  $after  Obtain list items below this thing ID.
     * @param  string|null  $before  Obtain list of items above this thing ID.
     *
     * @return object Listing of search results
     */
    public function search(
        $query,
        $subreddit = null,
        $sort = null,
        $time = null,
        $type = null,
        $limit = 25,
        $after = null,
        $before = null
    );

    /**
     * Retrieves information about the specified subreddit, including subreddit ID.
     *
     * @param  string  $subreddit  Name of subreddit for which to retrieve information.
     *
     * @return object Contains subreddit information.
     */
    public function aboutSubreddit($subreddit);

    /**
     * Retrieve a list of banned users from the specified subreddit. Must be a mod with access permissions.
     * Using pagination will result in the last item of the previous page appearing as the first item of the next page.
     *
     * @param  string  $subreddit  Subreddit for which to retrieve banned users.
     * @param  string|null  $user  Jump to a specific user. Will return an empty list if user is not on list.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of users.
     */
    public function getBanned($subreddit, $user = null, $limit = 25, $after = null, $before = null);

    /**
     * Retrieve a list of muted users from the specified subreddit. Must be a mod with access permissions.
     * Using pagination will result in the last item of the previous page appearing as the first item of the next page.
     *
     * @param  string  $subreddit  Subreddit for which to retrieve muted users.
     * @param  string|null  $user  Jump to a specific user. Will return an empty list if user is not on list.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of users.
     */
    public function getMuted($subreddit, $user = null, $limit = 25, $after = null, $before = null);

    /**
     * Retrieve a list of wiki banned users from the specified subreddit. Must be a mod with access permissions.
     * Using pagination will result in the last item of the previous page appearing as the first item of the next page.
     *
     * @param  string  $subreddit  Subreddit for which to retrieve wiki banned users.
     * @param  string|null  $user  Jump to a specific user. Will return an empty list if user is not on list.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of users.
     */
    public function getWikiBanned($subreddit, $user = null, $limit = 25, $after = null, $before = null);

    /**
     * Retrieve a list of approved submitters from the specified subreddit. Must be a mod or approved submitter in subreddit.
     * Using pagination will result in the last item of the previous page appearing as the first item of the next page.
     *
     * @param  string  $subreddit  Subreddit for which to retrieve approved submitters.
     * @param  string|null  $user  Jump to a specific user. Will return an empty list if user is not on list.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of users.
     */
    public function getContributors($subreddit, $user = null, $limit = 25, $after = null, $before = null);

    /**
     * Retrieve a list of approved wiki contributors from the specified subreddit. Must be a mod or approved wiki contributor in subreddit.
     * Using pagination will result in the last item of the previous page appearing as the first item of the next page.
     *
     * @param  string  $subreddit  Subreddit for which to retrieve approved wiki contributors.
     * @param  string|null  $user  Jump to a specific user. Will return an empty list if user is not on list.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of users.
     */
    public function getWikiContributors($subreddit, $user = null, $limit = 25, $after = null, $before = null);

    /**
     * Retrieve a list of moderators from the specified subreddit. Must have read access to subreddit.
     * This function does not use pagination, but it's here anyway in case that's changed in the future.
     *
     * @param  string  $subreddit  Subreddit for which to retrieve moderators.
     * @param  string|null  $user  Jump to a specific user. Will return an empty list if user is not on list.
     *
     * @return object Listing of users.
     */
    public function getModerators($subreddit, $user = null);

    /**
     * Upload an image to the specified subreddit.
     *
     * @param  string  $subreddit  Subreddit to which to upload image.
     * @param  string  $file  Relative or absolute path of file to upload from local machine.
     * @param  string  $name  If $upload_type is 'img', assign the image this name. Ignored otherwise.
     * @param  string  $upload_type  One of 'img', 'header', 'icon', 'banner'. As of now, 'icon' and 'banner' will result in an error.
     * @param  string  $image_type  One of 'png' or 'jpg'.
     *
     * @return object Response to API call. On success, shows image URL. Null if the local file cannot be found.
     */
    public function uploadSubredditImage($subreddit, $file, $name, $upload_type = 'img', $image_type = 'png');

    /**
     * Remove the subreddit's custom mobile banner.
     *
     * @param  string  $subreddit  Subreddit from which to remove the banner.
     *
     * @return object Response to API call.
     */
    public function deleteSubredditBanner($subreddit);

    /**
     * Remove the subreddit's custom header image.
     *
     * @param  string  $subreddit  Subreddit from which to remove the header image.
     *
     * @return object Response to API call.
     */
    public function deleteSubredditHeaderImage($subreddit);

    /**
     * Remove the subreddit's custom mobile icon.
     *
     * @param  string  $subreddit  Subreddit from which to remove the icon.
     *
     * @return object Response to API call.
     */
    public function deleteSubredditIcon($subreddit);

    /**
     * Remove an image from the subreddit's custom image set.
     *
     * @param  string  $subreddit  Subreddit from which to remove the image.
     * @param  string  $image_name  The name of the image to delete.
     *
     * @return object Response to API call.
     */
    public function deleteSubredditImage($subreddit, $image_name);

    /**
     * Retrieve a list of recommended subreddits based on the names of existing ones.
     *
     * @param  string  $subreddits  Comma-delimited list of subreddits on which to base recommendations.
     * @param  string|null  $omit  Omit these specific subreddits from results.
     *
     * @return array Recommended subreddit objects containing subreddit names.
     */
    public function getRecommendedSubreddits($subreddits, $omit = null): array;

    /**
     * List subreddit names that begin with a query string.
     *
     * @param  string  $query  Search for subreddits that start with this. Maximum 50 characters, all printable.
     * @param  bool  $include_nsfw  Include subreddits that are set as NSFW (over_18).
     * @param  bool  $exact  Only return exact match.
     *
     * @return object Contains an array of subreddit names.
     */
    public function searchSubredditsByName($query, $include_nsfw = true, $exact = false);

    /**
     * Retrieves the "submitting to /r/$subreddit" text for the selected subreddit.
     *
     * @param  string  $subreddit  Name of subreddit from which to obtain submit text.
     *
     * @return object Response to API call, containing the subreddit's submit_text.
     */
    public function getSubmitText($subreddit);

    /**
     * Get a subreddit's stylesheet.
     *
     * @param  string  $subreddit  Subreddit of which to retrieve stylesheet.
     *
     * @return object Wikipage object of subreddit's stylesheet, including text and list of images.
     */
    public function getSubredditStylesheet($subreddit);

    /**
     * Set a subreddit's stylesheet.
     *
     * @param  string  $subreddit  Subreddit of which to set stylesheet.
     * @param  string  $contents  Contents of stylesheet, probably pretty long.
     * @param  string|null  $reason  Since the stylesheet is a wiki page, optionally provide a reason for editing.
     *
     * @return object Response to API call, possibly containing errors if invalid CSS.
     */
    public function setSubredditStylesheet($subreddit, $contents, $reason = null);

    /**
     * Search for subreddits by topic keywords.
     *
     * @param  string  $query  Query with which to search.
     *
     * @return array List of objects containing subreddit names.
     */
    public function searchSubredditsByTopic($query): array;

    /**
     * Subscribe to a subreddit. Must have read access to the subreddit.
     *
     * @param  string  $subreddit  Subreddit to which to subscribe.
     *
     * @return object Response to API call, probably empty.
     */
    public function subscribe($subreddit);

    /**
     * Unsubscribe from a subreddit.
     *
     * @param  string  $subreddit  Subreddit from which to unsubscribe.
     *
     * @return object Response to API call, probably empty. 404 error if not already subscribed.
     */
    public function unsubscribe($subreddit);

    /**
     * Retrieve a list of the subreddit's settings. Must be a moderator.
     *
     * @param  string  $subreddit  The subreddit to retrieve.
     *
     * @return object Contains information about a subreddit's settings.
     */
    public function getSubredditSettings($subreddit);

    /**
     * Get a subreddit's sidebar contents.
     *
     * @param  string  $subreddit  Subreddit of which to retrieve sidebar.
     *
     * @return object Wikipage object of subreddit's sidebar.
     */
    public function getSubredditSidebar($subreddit);

    /**
     * Retrieve a subreddit's stickied posts.
     *
     * @param  string  $subreddit  Subreddit from which to retrieve sticky posts.
     *
     * @return array Contains link objects that are stickied in the subreddit. None if no sticky. If two, top sticky is first.
     */
    public function getStickies($subreddit): array;

    /**
     * Search for subreddits by title and description.
     *
     * @param  string  $query  Query with which to search
     * @param  string  $sort  Sorting method. One of 'relevance', 'activity'
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of subreddits that match the search query.
     */
    public function searchSubreddits($query, $sort = 'relevance', $limit = 25, $after = null, $before = null);

    /**
     * Retrieve a list of the current user's subscribed subreddits.
     *
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of subreddits.
     */
    public function getMySubscribedSubreddits($limit = 25, $after = null, $before = null);

    /**
     * Retrieve a list of the current user's subreddits in which they are an approved submitter.
     *
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of subreddits.
     */
    public function getMyContributedSubreddits($limit = 25, $after = null, $before = null);

    /**
     * Retrieve a list of the current user's subreddits in which they are a moderator.
     *
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of subreddits.
     */
    public function getMyModeratedSubreddits($limit = 25, $after = null, $before = null);

    /**
     * Retrieves a list of popular subreddits.
     *
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of subreddits.
     */
    public function getPopularSubreddits($limit = 25, $after = null, $before = null);

    /**
     * Retrieves a list of new subreddits.
     *
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of subreddits.
     */
    public function getNewSubreddits($limit = 25, $after = null, $before = null);

    /**
     * Retrieves a list of gold-only subreddits.
     *
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of subreddits.
     */
    public function getGoldOnlySubreddits($limit = 25, $after = null, $before = null);

    /**
     * Retrieves a list of default subreddits.
     *
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of subreddits.
     */
    public function getDefaultSubreddits($limit = 25, $after = null, $before = null);

    /**
     * Create a new subreddit.
     *
     * @param  string  $subreddit  Name of subreddit to create.
     * @param  array  $settings  An array containing a key-value pair for each option you want to set (TITLE IS REQUIRED):
     *                                         'allow_top' (boolean) Allow this subreddit to be included /r/all as well as the default and trending lists.
     *                                         'collapse_deleted_comments' (boolean) Collapse deleted and removed comments.
     *                                         'comment_score_hide_mins' (int) Minutes to hide comment scores.
     *                                         'description' (string) Sidebar text.
     *                                         'exclude_banned_modqueue' (boolean) Exclude posts by site-wide banned users from modqueue/unmoderated.
     *                                         'header-title' (string) Header mouseover text.
     *                                         'hide_ads' (boolean) Hide ads (only available for gold only subreddits).
     *                                         'lang' (string) Language, a valid IETF language tag (underscore separated).
     *                                         'link_type' (string) Content options. One of 'any', 'link', 'self'.
     *                                         'over_18' (boolean) Viewers must be over eighteen years old.
     *                                         'public_description' (string) Description, appears in search results and social media links.
     *                                         'public_traffic' (boolean) Make the traffic stats page available to everyone.
     *                                         'show_media' (boolean) Show thumbnail images of content.
     *                                         'spam_comments' (string) Spam filter strength for comments. One of 'low', 'high', 'all'.
     *                                         'spam_links' (string) Spam filter strength for links. One of 'low', 'high', 'all'.
     *                                         'spam_selfposts' (string) Spam filter strength for self posts. One of 'low', 'high', 'all'.
     *                                         'submit_link_label' (string) Custom label for submit link button (blank for default).
     *                                         'submit_text' (string) Submission text, text to show on submission page.
     *                                         'submit_text_label' (string) Custom label for submit text post button (blank for default).
     *                                         'suggested_comment_sort' (string) Suggested comment sort. One of 'confidence', 'top', 'new', 'hot', 'controversial', 'old', 'random', 'qa'
     *                                         'title' (string) Subreddit title, shown in the browser tab.
     *                                         'type' (string) Subreddit type. One of 'restricted', 'private', 'public'. Other values are 'gold_restricted', 'archived', 'gold_only' and 'employees_only', but result in errors.
     *                                         'wiki_edit_age' (int) Account age (days) required to edit and create wiki pages.
     *                                         'wiki_edit_karma' (int) Subreddit karma required to edit and create wiki pages.
     *                                         'wikimode' (string) Who should be able to edit the wiki. One of 'disabled', 'modonly', 'anyone'.
     * @param  bool  $i_read_the_documentation  Must be set to true to show that you've read this.
     *
     * @return object Response to API call. (Watch for RATELIMIT errors.)
     */
    public function createSubreddit($subreddit, $settings, $i_read_the_documentation = false);

    /**
     * Change a subreddit's configuration.
     *
     * @param  string  $subreddit  Name of subreddit to change.
     * @param  array  $settings  An array containing a key-value pair for each option you want to change:
     *                                         'allow_top' (boolean) Allow this subreddit to be included /r/all as well as the default and trending lists.
     *                                         'collapse_deleted_comments' (boolean) Collapse deleted and removed comments.
     *                                         'comment_score_hide_mins' (int) Minutes to hide comment scores.
     *                                         'description' (string) Sidebar text.
     *                                         'exclude_banned_modqueue' (boolean) Exclude posts by site-wide banned users from modqueue/unmoderated.
     *                                         'header-title' (string) Header mouseover text.
     *                                         'hide_ads' (boolean) Hide ads (only available for gold only subreddits).
     *                                         'lang' (string) Language, a valid IETF language tag (underscore separated).
     *                                         'link_type' (string) Content options. One of 'any', 'link', 'self'.
     *                                         'over_18' (boolean) Viewers must be over eighteen years old.
     *                                         'public_description' (string) Description, appears in search results and social media links.
     *                                         'public_traffic' (boolean) Make the traffic stats page available to everyone.
     *                                         'show_media' (boolean) Show thumbnail images of content.
     *                                         'spam_comments' (string) Spam filter strength for comments. One of 'low', 'high', 'all'.
     *                                         'spam_links' (string) Spam filter strength for links. One of 'low', 'high', 'all'.
     *                                         'spam_selfposts' (string) Spam filter strength for self posts. One of 'low', 'high', 'all'.
     *                                         'submit_link_label' (string) Custom label for submit link button (blank for default).
     *                                         'submit_text' (string) Submission text, text to show on submission page.
     *                                         'submit_text_label' (string) Custom label for submit text post button (blank for default).
     *                                         'suggested_comment_sort' (string) Suggested comment sort. One of 'confidence', 'top', 'new', 'hot', 'controversial', 'old', 'random', 'qa'.
     *                                         'title' (string) Subreddit title, shown in the browser tab.
     *                                         'type' (string) Subreddit type. One of 'restricted', 'private', 'public'. Other values are 'gold_restricted', 'archived', 'gold_only' and 'employees_only', but result in errors.
     *                                         'wiki_edit_age' (int) Account age (days) required to edit and create wiki pages.
     *                                         'wiki_edit_karma' (int) Subreddit karma required to edit and create wiki pages.
     *                                         'wikimode' (string) Who should be able to edit the wiki. One of 'disabled', 'modonly', 'anyone'.
     * @param  bool  $i_read_the_documentation  Must be set to true to show that you've read this.
     *
     * @return object Response to API call. (RATELIMIT errors can be ignored if you have recently created a subreddit.)
     */
    public function editSubreddit($subreddit, $settings, $i_read_the_documentation = false);

    /**
     * Adds the specified user as a friend.
     *
     * @param  string  $user  Username of friend to add.
     * @param  string|null  $note  Note to add to friend record. Currently only available to those with reddit gold.
     *
     * @return object A friend record object.
     */
    public function addFriend($user, $note = null);

    /**
     * Removes the specified user as a friend.
     *
     * @param  string  $user  Username of user to remove.
     *
     * @return null Response to API call, null for some reason.
     */
    public function removeFriend($user);

    /**
     * Unblock a user by username.
     *
     * @param  string  $user  Username of user to unblock.
     *
     * @return object Response to API call.
     */
    public function unblockUser($user);

    /**
     * Presumably checks whether the specified username is available, but endpoint is not working at this time.
     *
     * @param  string  $username  Username to check for availability.
     *
     * @return object Response to API call.
     */
    public function usernameAvailable($username);

    /**
     * Check notifications? Not documented by reddit.
     *
     * @param  string|null  $start_date  Start date of notification records.
     * @param  string|null  $end_date  End date of notification records.
     * @param  string|null  $sort  One of 'new', 'old', or null.
     *
     * @return array List of notification objects from reddit.
     */
    public function getNotifications($start_date = null, $end_date = null, $sort = null): array;

    /**
     * Mark a notification as read based on its thing ID.
     *
     * @param  string  $thing_id  Thing ID of the notification to mark as read.
     * @param  bool  $read  Whether or not to mark as read. False doesn't seem to be working.
     *
     * @return mixed Response to API call, probably null, but could change in the future.
     */
    public function markNotificationAsRead($thing_id, $read = true);

    /**
     * Get a user's trophies.
     *
     * @param  string  $user  Username of user for whom to retrieve trophies.
     *
     * @return object Listing of trophies.
     */
    public function getUserTrophies($user);

    /**
     * Retrieve information about the specified user.
     *
     * @param  string  $user  Username of user to retrieve.
     *
     * @return object Response to API call containing user object.
     */
    public function getUser($user);

    /**
     * Obtain posts and comments made by the specified user.
     *
     * @param  string  $user  Username of user for whom to retrieve records. Defaults to the current user.
     * @param  string|null  $sort  Sorting method. One of 'hot', 'new', 'top', 'controversial', or null.
     * @param  string|null  $time  One of 'hour', 'day', 'week', 'month', 'year', 'all', or null.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of posts and comments made by the specified user.
     */
    public function getUserOverview(
        $user = null,
        $sort = null,
        $time = null,
        $limit = 25,
        $after = null,
        $before = null
    );

    /**
     * Obtain only posts made by the specified user.
     *
     * @param  string  $user  Username of user for whom to retrieve records. Defaults to the current user.
     * @param  string|null  $sort  Sorting method. One of 'hot', 'new', 'top', 'controversial', or null.
     * @param  string|null  $time  One of 'hour', 'day', 'week', 'month', 'year', 'all', or null.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of posts comments made by the specified user.
     */
    public function getUserSubmitted(
        $user = null,
        $sort = null,
        $time = null,
        $limit = 25,
        $after = null,
        $before = null
    );

    /**
     * Obtain only comments made by the specified user.
     *
     * @param  string  $user  Username of user for whom to retrieve records. Defaults to the current user.
     * @param  string|null  $sort  Sorting method. One of 'hot', 'new', 'top', 'controversial', or null.
     * @param  string|null  $time  One of 'hour', 'day', 'week', 'month', 'year', 'all', or null.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of comments made by the specified user.
     */
    public function getUserComments(
        $user = null,
        $sort = null,
        $time = null,
        $limit = 25,
        $after = null,
        $before = null
    );

    /**
     * Obtain posts and comments upvoted by the specified user.
     *
     * @param  string  $user  Username of user for whom to retrieve records. Defaults to the current user.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of posts and comments upvoted by the specified user.
     */
    public function getUserUpvoted($user = null, $limit = 25, $after = null, $before = null);

    /**
     * Obtain posts and comments downvoted by the specified user.
     *
     * @param  string  $user  Username of user for whom to retrieve records. Defaults to the current user.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of posts and comments downvoted by the specified user.
     */
    public function getUserDownvoted($user = null, $limit = 25, $after = null, $before = null);

    /**
     * Obtain posts and comments hidden by the specified user.
     *
     * @param  string  $user  Username of user for whom to retrieve records. Defaults to the current user.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of posts and comments hidden by the specified user.
     */
    public function getUserHidden($user = null, $limit = 25, $after = null, $before = null);

    /**
     * Obtain posts and comments saved by the specified user.
     *
     * @param  string  $user  Username of user for whom to retrieve records. Defaults to the current user.
     * @param  string|null  $sort  Sorting method. One of 'hot', 'new', 'top', 'controversial', or null.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of posts and comments saved by the specified user.
     */
    public function getUserSaved($user = null, $sort = null, $limit = 25, $after = null, $before = null);

    /**
     * Obtain posts and comments gilded (received) by the specified user.
     *
     * @param  string  $user  Username of user for whom to retrieve records. Defaults to the current user.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of posts and/or comments made by the specified user.
     */
    public function getUserGildingsReceived($user = null, $limit = 25, $after = null, $before = null);

    /**
     * Obtain posts and comments gilded (given) by the specified user.
     *
     * @param  string  $user  Username of user for whom to retrieve records. Defaults to the current user.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of posts and/or comments made by the specified user.
     */
    public function getUserGildingsGiven($user = null, $limit = 25, $after = null, $before = null);

    /**
     * Allow the specified user to edit the specified wiki page.
     *
     * @param  string  $subreddit  Subreddit of the wiki page.
     * @param  string  $username  Username of user to allow.
     * @param  string  $pagename  Name of page to allow user to edit.
     *
     * @return object Response to API call. Probably empty, but could contain errors, such as PAGE_NOT_FOUND.
     */
    public function wikiAllowEditor($subreddit, $username, $pagename);

    /**
     * Remove the specified user from the allowed editors list of the specified wiki page.
     *
     * @param  string  $subreddit  Subreddit of the wiki page.
     * @param  string  $username  Username of user to allow.
     * @param  string  $pagename  Name of page to disallow user to edit.
     *
     * @return object Response to API call. Probably empty, but could contain errors, such as PAGE_NOT_FOUND.
     */
    public function wikiDisallowEditor($subreddit, $username, $pagename);

    /**
     * Retrieves a list of all pages of the specified subreddit's wiki.
     *
     * @param  string  $subreddit  Subreddit for which to retrieve pages.
     *
     * @return object Listing of wiki pages.
     */
    public function wikiGetPages($subreddit);

    /**
     * Retrieves the specified wiki page, optionally at a specific revision or a comparison between revisions.
     *
     * @param  string  $subreddit  Subreddit in which to retrieve page.
     * @param  string  $pagename  Page to retrieve.
     * @param  string|null  $revision_id  Specific revision ID to retrieve (optional).
     * @param  string|null  $compare_with  ID of revision with which to compare $revision_id (optional2). May not be working.
     *
     * @return mixed
     */
    public function wikiGetPage($subreddit, $pagename, $revision_id = null, $compare_with = null);

    /**
     * Retrieves a listing of wiki revisions for all pages within the specified subreddit.
     *
     * @param  string  $subreddit  Subreddit for which to retrieve revisions.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of wiki page revisions.
     */
    public function wikiGetRevisions($subreddit, $limit = 25, $after = null, $before = null);

    /**
     * Retrieves a listing of wiki revisions for the specified page within the specified subreddit.
     *
     * @param  string  $subreddit  Subreddit for which to retrieve revisions.
     * @param  string  $pagename  Page for which to retrieve revisions.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of wiki page revisions.
     */
    public function wikiGetPageRevisions($subreddit, $pagename, $limit = 25, $after = null, $before = null);

    /**
     * Edit or create a wiki page.
     *
     * @param  string  $subreddit  Subreddit in which to edit page.
     * @param  string  $pagename  Page to edit.
     * @param  string  $content  Content with which to overwrite page.
     * @param  string|null  $reason  Reason for revision, optional.
     * @param  string|null  $previous  Revision ID on which to base this edit. Handled by function, so optional.
     *
     * @return object
     */
    public function wikiEditPage($subreddit, $pagename, $content, $reason = null, $previous = null);

    /**
     * Toggle a revision's status of hidden.
     *
     * @param  string  $subreddit  Subreddit of revision.
     * @param  string  $pagename  Pagename of revision.
     * @param  string  $revision_id  ID of revision to toggle hidden status.
     *
     * @return object Response to API call. Status attribute is true if the revision is now hidden, false if shown.
     */
    public function wikiToggleHideRevision($subreddit, $pagename, $revision_id);

    /**
     * Hide a revision from revision listing.
     * This may take two calls, since the only way to get a revision's hidden status is to toggle it.
     *
     * @param  string  $subreddit  Subreddit of revision.
     * @param  string  $pagename  Pagename of revision.
     * @param  string  $revision_id  ID of revision to hide.
     *
     * @return object Response to API call. Status attribute is true if the revision is now hidden, false if shown.
     */
    public function wikiHideRevision($subreddit, $pagename, $revision_id);

    /**
     * Unhide a revision in the revision listing.
     * This may take two calls, since the only way to get a revision's hidden status is to toggle it.
     *
     * @param  string  $subreddit  Subreddit of revision.
     * @param  string  $pagename  Pagename of revision.
     * @param  string  $revision_id  ID of revision to unhide.
     *
     * @return object Response to API call. Status attribute is true if the revision is now hidden, false if shown.
     */
    public function wikiUnhideRevision($subreddit, $pagename, $revision_id);

    /**
     * Revert a wiki page to a previous revision.
     *
     * @param  string  $subreddit  Subreddit of revision.
     * @param  string  $pagename  Pagename of revision.
     * @param  string  $revision_id  ID of revision to which to revert.
     *
     * @return object Response to API call, probably empty.
     */
    public function wikiRevertToRevision($subreddit, $pagename, $revision_id);

    /**
     * Retrieves a listing of discussions about a certain wiki page.
     *
     * @param  string  $subreddit  Subreddit of page.
     * @param  string  $pagename  Page for which to retrieve discussions.
     * @param  int  $limit  Upper limit of number of items to retrieve. Maximum is 100.
     * @param  string|null  $after  Get items lower on list than this entry. Does not mean chronologically.
     * @param  string|null  $before  Get items higher on list than this entry. Does not mean chronologically.
     *
     * @return object Listing of posts.
     */
    public function wikiGetPageDiscussions($subreddit, $pagename, $limit = 25, $after = null, $before = null);

    /**
     * Get the specified page's settings in the specified subreddit.
     *
     * @param  string  $subreddit  Subreddit of page.
     * @param  string  $pagename  Name of page.
     *
     * @return object Settings object for wiki page.
     */
    public function wikiGetPageSettings($subreddit, $pagename);

    /**
     * Update the specified page's settings in the specified subreddit.
     *
     * @param  string  $subreddit  Subreddit of page.
     * @param  string  $pagename  Name of page.
     * @param  int|null  $permlevel  Permissions level for page. 0 for use subreddit wiki permissions, 1 for only approved editors, 2 for only mods, null to not update.
     * @param  bool|null  $listed  Show this page on the list of wiki pages. True to show, false to hide, null to not update.
     *
     * @return object Settings object for wiki page.
     */
    public function wikiUpdatePageSettings($subreddit, $pagename, $permlevel = null, $listed = null);

    public function apiCall($path, $method = 'GET', $params = null, $json = false);
}
