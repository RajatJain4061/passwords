<?php

namespace {
    class OC_Defaults {
        public function getTextColorPrimary() {return '';}
        public function getLogo() {return '';}
        public function getEntity() {return '';}
        public function getColorPrimary() {return '';}
    }
}

namespace OCP\AppFramework {
    use OCP\Route\IRouter;
    class App {
        public static function buildAppNamespace(string $appId, string $topNamespace = 'OCA\\'): string {return 'OCA\\Passwords\\';}
        public function __construct(string $appName, array $urlParams = []) {}
        public function getContainer(): IAppContainer {return new IAppContainer();}
        public function registerRoutes(IRouter $router, array $routes) {}
        public function dispatch(string $controllerName, string $methodName) {}
    }
}


namespace OCP\L10N {
    use OCP\IUser;
    interface IFactory {
        public function get($app, $lang = null, $locale = null);
        public function findLanguage($app = null);
        public function findLocale($lang = null);
        public function findLanguageFromLocale(string $app = 'core', string $locale = null);
        public function findAvailableLanguages($app = null);
        public function findAvailableLocales();
        public function languageExists($app, $lang);
        public function localeExists($locale);
        public function createPluralFunction($string);
        public function getLanguageIterator(IUser $user = null): ILanguageIterator;
    }
}

namespace OCP {
    class IGroup {
        public function getUsers() { return  []; }
    }

    class IGroupManager {
        public function get() {return new IGroup();}
    }

    interface IUser {
        public function getUID();
    }

    class IURLGenerator {
        public function getAbsoluteURL(string $url): string {return '';}
        public function imagePath(string $appName, string $file): string {return '';}
        public function linkToRouteAbsolute(string $routeName, array $arguments = []): string {return '';}
    }
}

namespace OC\User {
    use \OCP\IUser;
    class User implements IUser{
        public function getUID(): string {return '';}
        public function getDisplayName() {}
        public function setDisplayName($displayName) {}
        public function getLastLogin() {}
        public function updateLastLoginTimestamp() {}
        public function delete() {}
        public function setPassword($password, $recoveryPassword = null) {}
        public function getHome() {}
        public function getBackendClassName() {}
        public function getBackend() {}
        public function canChangeAvatar() {}
        public function canChangePassword() {}
        public function canChangeDisplayName() {}
        public function isEnabled() {}
        public function setEnabled(bool $enabled = true) {}
        public function getEMailAddress() {}
        public function getAvatarImage($size) {}
        public function getCloudId() {}
        public function setEMailAddress($mailAddress) {}
        public function getQuota() {}
        public function setQuota($quota) {}
    }
}

namespace OCP\Notification {
    interface INotification {
        public function setApp(string $app): INotification;
        public function getApp(): string;
        public function setUser(string $user): INotification;
        public function getUser(): string;
        public function setDateTime(\DateTime $dateTime): INotification;
        public function getDateTime(): \DateTime;
        public function setObject(string $type, string $id): INotification;
        public function getObjectType(): string;
        public function getObjectId(): string;
        public function setSubject(string $subject, array $parameters = []): INotification;
        public function getSubject(): string;
        public function getSubjectParameters(): array;
        public function setParsedSubject(string $subject): INotification;
        public function getParsedSubject(): string;
        public function setRichSubject(string $subject, array $parameters = []): INotification;
        public function getRichSubject(): string;
        public function getRichSubjectParameters(): array;
        public function setMessage(string $message, array $parameters = []): INotification;
        public function getMessage(): string;
        public function getMessageParameters(): array;
        public function setParsedMessage(string $message): INotification;
        public function getParsedMessage(): string;
        public function setRichMessage(string $message, array $parameters = []): INotification;
        public function getRichMessage(): string;
        public function getRichMessageParameters(): array;
        public function setLink(string $link): INotification;
        public function getLink(): string;
        public function setIcon(string $icon): INotification;
        public function getIcon(): string;
        public function createAction(): IAction;
        public function addAction(IAction $action): INotification;
        public function getActions(): array;
        public function addParsedAction(IAction $action): INotification;
        public function getParsedActions(): array;
        public function isValid(): bool;
        public function isValidParsed(): bool;
    }

    interface INotifier {
        public function getID(): string;
        public function getName(): string;
        public function prepare(INotification $notification, string $languageCode): INotification;
    }
}

namespace OCP\Migration {
    interface IOutput {
        public function info($message);
        public function warning($message);
        public function startProgress($max = 0);
        public function advance($step = 1, $description = '');
        public function finishProgress();
    }

    interface IRepairStep {
        public function getName();
        public function run(IOutput $output);
    }
}

namespace OC\Migration {
    use OCP\Migration\IOutput;
    class SimpleOutput implements IOutput {
        public function info($message) {}
        public function warning($message) {}
        public function startProgress($max = 0) {}
        public function advance($step = 1, $description = '') {}
        public function finishProgress() {}
    }
}

namespace OCP\Files\SimpleFS {
    interface ISimpleFile {}
}

namespace OC\Files\SimpleFS {
    use OCP\Files\SimpleFS\ISimpleFile;
    class SimpleFile implements ISimpleFile{
        public function getName() {}
        public function getSize() {}
        public function getETag() {}
        public function getMTime() {}
        public function getContent() {}
        public function putContent($data) {}
        public function delete() {}
        public function getMimeType() {}
        public function read() {}
        public function write() {}
    }
}