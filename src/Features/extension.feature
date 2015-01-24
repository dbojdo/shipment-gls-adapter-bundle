Feature: WebitShipmentGlsAdapterBundle - Service container extension
  In order to bootstrap GLS-ADE and GLS Track & Trace adapter for Web-IT shipment
  As a developer
  I want register GlsAdeShipmentAdapter libraries services in Container

  Scenario: Loading services
    Given application is up
    Then there should be following services in container:
    """
    webit_shipment_gls_adapter.adapter_factory,webit_shipment_gls_adapter.adapter
    """

  Scenario: Default sender address provider
    Given there is service "default_sender_address_provider" of type "Webit\Shipment\GlsAdapter\Sender\DefaultSenderAddressProviderInterface"
    And application config contains:
    """
    webit_shipment_gls_adapter:
      ade_account: alias-1
      trace_account: alias-1
      default_sender_address_provider: default_sender_address_provider
    """
    When application is up
    Then there should be following services in container:
    """
    webit_shipment_gls_adapter.sender.default_sender_address_provider
    """

  Scenario: Default sender address
    Given application config contains:
    """
    webit_shipment_gls_adapter:
      ade_account: alias-1
      trace_account: alias-1
      default_sender_address:
          name1: Buckingham Palace
          name2: Queen residence
          name3: Additional description
          address: Westminster
          post_code: SW1A 1AA
          post: London
          country: GB
    """
    Then there should be following services in container:
    """
    webit_shipment_gls_adapter.sender.default_sender_address_provider
    """
    And service "webit_shipment_gls_adapter.sender.default_sender_address_provider" should provide SenderAddress like:
    | property | value                  |
    | name1    | Buckingham Palace      |
    | name2    | Queen residence        |
    | name3    | Additional description |
    | street   | Westminster            |
    | zipCode  | SW1A 1AA               |
    | city     | London                 |
    | country  | GB                     |
