# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [2.0.0] - 2024-12-05

### Updated
- Upgraded the QR code generation library to the latest version of endroid/qr-code.

### Changed
- Refactored the implementation of QR code generation to align with the updated library.
- Breaking change: Applications using this library must update their QR generation code to ensure compatibility with the new implementation.

## [0.1.1] - 2021-06-02

### Changed
- Minimal PHP version: 7.3.

### Fixed
- Crypto QR without protocol return only address.
